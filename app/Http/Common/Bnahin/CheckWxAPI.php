<?php
/**
 * Communicate with CheckWx API
 * @author Blake Nahin <blake@zseartcc.org>
 */

namespace App\Http\Common\Bnahin;

use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleHTTP;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;


class CheckWxAPI
{
    public $defaultAirport;
    public $defaultAirportFile = 'vatusa/wx/default.json';

    protected $api;

    private $cacheMinutes = 5;

    public function __construct()
    {
        $this->api = new GuzzleHTTP(
            [
                'base_uri' => config('services.checkwx.base_uri'),
                'timeout'  => 10.0,
                'headers'  => [
                    'X-API-KEY' => config('services.checkwx.key')
                ]
            ]);
        $this->defaultAirport = config('services.checkwx.default_airport');
    }

    /**
     * Get METAR data for search. (AJAX)
     *
     * @param bool                     $default
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array | \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getMetarData($default = false, Request $request = null)
    {
        if (!$default) {
            $airport = Str::upper($request->validate([
                'airport' => 'required|min:3|max:4'
            ])['airport']);
            if ($airport == $this->defaultAirport || "K$airport" == $this->defaultAirport) {
                return response()->json($this->getDefaultAirportData());
            }
            if (Cache::has('metar-' . $airport)) {
                return response()->json(json_decode(Cache::get('metar-' . $airport)));
            }
        } else {
            $airport = Str::upper($this->defaultAirport);
        }

        $metarDec = $this->callApi("metar/$airport/decoded");
        if (!is_array($metarDec)) {
            if (!$default) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Unable to retrieve METAR. Please try again later.'
                ]);
            } else {
                abort(500, 'Unable to communicate with METAR reporting server.');
            }
        }
        $metarRaw = $metarDec['raw_text'];

        $taf = $this->callApi("taf/$airport");
        if (str_contains($taf, 'Unavailable')) {
            if (!$default) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Unable to retrieve METAR. Please try again later.'
                ], 422);
            } else {
                abort(500, 'Unable to communicate with METAR reporting server.');
            }
        }

        $station = $this->callApi("station/$airport");
        $apName = $station['name'];
        $apCity = ($station['city'] ?? '') . ', ' . ($station['state'] ?? '');

        $taf = implode('<br>FM', explode('FM', $taf));

        $return = array(
            'status'  => true,
            'airport' => $airport,
            'name'    => $apName . " Airport",
            'city'    => $apCity,
            'raw'     => $metarRaw,
            'dec'     => $this->parseDecodedMetar($metarDec),
            'taf'     => $taf
        );
        if (!$default) {
            Cache::put('metar-' . $airport, json_encode($return), $this->cacheMinutes);
        }

        return ($default) ? $return : response()->json($return);
    }

    /**
     * Make CheckWX API Call
     *
     * @param string $uri
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function callApi(string $uri)
    {
        try {
            $data = $this->api->get($uri);
        } catch (RequestException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Unable to make API request. Please try again later.'
            ]);
        }
        if (!$data || $data->getStatusCode() != 200) {
            return response()->json([
                'status'  => false,
                'message' => 'Unable to communicate with API. Please try again later.'
            ]);
        }

        return json_decode($data->getBody(), true)['data'][0];
    }

    /**
     * Parse decoded METAR for readable output
     *
     * @param array $dec
     *
     * @return array
     */
    private function parseDecodedMetar(array $dec)
    {
        $cat = $dec['flight_category'] ?? "<span class='label label-default'>N/A</span>";
        switch ($cat) {
            case 'VFR':
                $cat = "<span class='label label-success'>VFR</span>";
                break;
            case 'MVFR':
                $cat = "<span class='label label-info'>MVFR</span>";
                break;
            case 'IFR':
                $cat = "<span class='label label-danger'>IFR</span>";
                break;
            case 'LIFR':
                $cat = "<span class='label label-warning'>LIFR</span>";
                break;
        }

        $wind = "Calm";
        if ($windDir = $dec['wind']['degrees']) {
            $windSpd = $dec['wind']['speed_kts'];
            $wind = "$windDir&deg; at $windSpd knots";
        }

        $visibility = ($dec['visibility']['miles'] ?? 'Unavailable') . " SM";

        $cond = $dec['conditions'] ?? null;
        if ($cond && $text = $dec['conditions']['text'] ?? '') {
            if (!$text && str_contains($dec['raw_text'], 'BR')) {
                $text = 'Mist';
            }
            $visibility .= "<br>$text";
        }

        $clouds = $dec['clouds'] ?? 'Clear';
        if (!$clouds || !is_array($clouds) || !$clouds[0]['base_feet_agl']) {
            $clouds = 'Clear below 12,000';
        } else {
            $numLayers = count($clouds);
            $cloudsBlock = "";
            $hasCeiling = false;
            $isCeiling = false;
            foreach ($clouds as $cloud) {
                if ($isCeiling = in_array($cloud['code'], ['BKN', 'OVC']) && !$hasCeiling) {
                    $cloudsBlock .= "<strong>";
                    $hasCeiling = true;
                }
                $currLayer = 1;

                $cloudsBlock .= $cloud['text'] . " at " . number_format($cloud['base_feet_agl']);
                if ($isCeiling) {
                    $cloudsBlock .= "</strong>";
                }
                if ($numLayers != $currLayer) {
                    $cloudsBlock .= "<br>";
                }
            }
            $clouds = $cloudsBlock;
        }

        $temp = "Temperature: " . $dec['temperature']['celsius'] . "&deg;C" ?? 'Unavailable';
        $dew = "Dewpoint: " . $dec['dewpoint']['celsius'] . "&deg;C" ?? 'Unavailable';
        $tempBlock = "$temp<br>$dew";

        $baro = $dec['barometer']['hg'] ?? 'Unavailable';

        if (is_float($baro)) {
            if ($baro >= 29.92) {
                $lowestUsable = "FL180";
            } elseif ($baro <= 29.91 && $baro >= 29.42) {
                $lowestUsable = "FL185";
            } elseif ($baro <= 29.41 && $baro >= 28.92) {
                $lowestUsable = "FL190";
            } elseif ($baro <= 28.91 && $baro >= 28.42) {
                $lowestUsable = "FL195";
            } elseif ($baro <= 28.41 && $baro >= 27.92) {
                $lowestUsable = "FL200";
            } elseif ($baro <= 27.91 && $baro >= 27.42) {
                $lowestUsable = "FL205";
            } elseif ($baro <= 27.41 && $baro >= 26.92) {
                $lowestUsable = "FL210";
            } else {
                $lowestUsable = 'N/A';
            }
            $baro .= " (Lowest Usable: $lowestUsable)";
        }

        return compact('cat', 'wind', 'visibility', 'clouds', 'tempBlock', 'baro');

    }

    /**
     * Get default airport data.
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getDefaultAirportData()
    {
        $data = array();

        if (Storage::exists($this->defaultAirportFile)) {
            try {
                $data = json_decode(Storage::get($this->defaultAirportFile), true);
            } catch (FileNotFoundException $e) {
                abort(500, $e->getMessage());
            }
        } else {
            $data = $this->getMetarData(true);
        }

        return $data;
    }
}