<?php

namespace App\Http\Controllers;

use App\Http\Common\Bnahin\CheckWxAPI;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $api;

    public function __construct(CheckWxAPI $api)
    {
        $this->api = $api;
    }

    /**
     * Show weather page.
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function index()
    {
        return view('weather')
            ->with('default', $this->api->getDefaultAirportData());
    }

    /**
     * Get airport weather data (AJAX)
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function metar(Request $request)
    {
        return $this->api->getMetarData(false, $request);
    }
}
