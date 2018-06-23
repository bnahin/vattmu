{{-- Extends Layout --}}
@extends('layouts.master')

{{-- Page Title --}}
@section('page-title', 'Weather')

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    {!! Breadcrumbs::render('weather') !!}
@endsection

{{-- Header Extras to be Included --}}
@section('head-extras')
    @parent
@endsection

{{-- Pace.js --}}
@push('extra-styles')
    <link href="{{ asset('adminlte/plugins/pace/pace.min.css') }}" rel="stylesheet">
@endpush
@push('footer-scripts')
    <script src="{{ asset('adminlte/plugins/pace/pace.min.js') }}"></script>
@endpush

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info" id="metar-box">
                <div class="box-header with-border"><h3 class="box-title">METAR & TAF Search</h3></div>
                <div class="box-body">
                    <div class="col-md-4" id="search-col">
                        <div class="input-group margin" id="metar-search">
                            <input class="form-control" type="text" name="metar-airport" id="metar-airport"
                                   placeholder="ex. KSEA" value="{{ $default['airport'] }}" required>
                            <span class="input-group-btn">
                      <button type="button" class="btn btn-success btn-flat" id="metar-search-submit">Go!</button>
                                <br>
                                </span>

                        </div>
                        <p class="help-block">Input an airport's 3 letter IATA or 4 letter ICAO code to retrieve its
                            most current
                            METAR and TAF. </p>
                        <div class="callout callout-info" id="airport-block">
                            <h4 id="ap-name">{{ $default['name'] }}</h4>

                            <p id="ap-city">{{ $default['city'] }}</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h5><strong>METAR: </strong> <span id="raw-metar">{!! $default['raw'] !!}</span>
                        </h5>

                        <table class="table table-bordered dec-body">
                            <tbody>
                            <tr>
                                <th>Cond.</th>
                                <th>Wind</th>
                                <th>Visibility</th>
                                <th>Clouds</th>
                                <th>Temp.</th>
                                <th>Altimeter</th>
                            </tr>
                            <tr id='dec-row'>
                                <td id="cat">{!! $default['dec']['cat'] !!}</td>
                                <td id="wind">{!! $default['dec']['wind'] !!}</td>
                                <td id="cond">{!! $default['dec']['visibility'] !!}</td>
                                <td id="clouds">{!! $default['dec']['clouds'] !!}</td>
                                <td id="temp">{!! $default['dec']['tempBlock'] !!}</td>
                                <td id="baro">{!! $default['dec']['baro'] !!}</td>
                            </tr>
                            </tbody>
                        </table>
                        <hr>
                        <h5><strong>TAF: </strong> <span id="taf">{!! $default['taf'] !!}</span></h5>
                    </div>
                </div>
            </div>
            <div class="box box-success" id="atis-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Online ATIS</h3>
                </div>
                <div class="box-body">
                    <div class="info-box atis-box">
                        <span class="info-box-left bg-aqua">
                            <div class="atis-icao">KSEA</div>
                            <span class="atis-letter">A</span>
                            <div class="atis-name">Blake Nahin</div></span>

                        <div class="info-box-content">
                            <table class="table table-responsive table-bordered atis-table">
                                <tbody>
                                <tr>
                                    <td class="metar" colspan="5">KPIE 260853Z AUTO 02013G17KT
                                        10SM CLR 17/07 A2998 RMK AO2 SLP153 T01720072 57000
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" rowspan="2" width="16%">
                                        <strong>Landing:</strong> 16L, 16R<br>
                                        <strong>Departing:</strong> 16R
                                    </td>
                                    <td width="15%"><strong>Altimeter:</strong> 29.92
                                    </td>
                                    <td rowspan="2" width="10%" valign="TOP"><strong>Temp:</strong>
                                        35&deg;F
                                        <br>
                                        <strong>Dew:</strong> 30&deg;F
                                    </td>
                                    <td rowspan="3" width="59%" valign="TOP">Overcast
                                        at 9,000
                                    </td>
                                </tr>
                                <tr>
                                    <td width="15%"><strong>Wind</strong>: 350 @ 8</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    ATIS letter (bigger), name (below letter), airport (above letter) metar (right; raw/decoded)
                    Expandable ATIS content

                    In separated collapsable boxes
                </div>
            </div>
        </div>
    </div>
@endsection