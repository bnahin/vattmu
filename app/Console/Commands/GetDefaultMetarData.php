<?php

namespace App\Console\Commands;

use App\Http\Common\Bnahin\CheckWxAPI;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class GetDefaultMetarData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wx:default 
                            {icao? : 4-letter ICAO code of new default airport. }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download weather data for the default airport.';

    /**
     * The CheckWxAPI instance.
     * @var \App\Http\Common\Bnahin\CheckWxAPI $api
     */
    protected $api;

    /**
     * Create a new command instance.
     *
     * @param \App\Http\Common\Bnahin\CheckWxAPI $api
     */
    public function __construct(CheckWxAPI $api)
    {
        parent::__construct();

        $this->api = $api;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        if ($this->hasArgument('icao') && $ap = $this->argument('icao')) {
            $this->error('Changing default airport is currently a work in progress.');
            //Save to database, add front end admin option
        }
        /*  $ap = $this->argument('icao');
          if (strlen($ap) > 2 && strlen($ap) < 5) {
              $this->info('Changing default airport from ' . $this->api->defaultAirport . ' to ' . $ap . '!');
              Config::set('services.checkwx.default_airport', $ap);
              $this->api->defaultAirport = $ap;
          } else {
              $this->error('Invalid airport code!');

              return 1;
          }
      }
        */
        $data = $this->api->getMetarData(true);
        Storage::put('vatusa/wx/default.json', json_encode($data));

        $this->info('Weather data for ' . $this->api->defaultAirport . ' successfully downloaded!');
        $this->info($data['raw']);

        return 0;
    }
}
