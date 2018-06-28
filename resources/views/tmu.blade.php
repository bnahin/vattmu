{{-- Extends Layout --}}
@extends('layouts.master')

{{-- Page Title --}}
@section('page-title', 'TMU Map')

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    {!! Breadcrumbs::render('tmu') !!}
@endsection

{{-- Header Extras to be Included --}}
@section('head-extras')
    @parent
@endsection

@push('footer-scripts')
    <script src="{{ cdn_asset('adminlte/js/plugins/typeahead/typeahead.bundle.min.js') }}"></script>
    <script>
      var west = new Bloodhound({
        //Western Region
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('artcc'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch      : 'public/storage/maps/west.json'
      })

      var northeast = new Bloodhound({
        //Northeastern Region
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('artcc'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch      : 'public/storage/maps/north.json'
      })
      var southern = new Bloodhound({
        //Southern Region
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('artcc'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch      : 'public/storage/maps/south.json'
      })

      $('#artcc-search .typeahead').typeahead({
          highlight: true
        },
        {
          name     : 'west-artccs',
          display  : 'artcc',
          source   : west,
          templates: {
            header: '<h3 class="league-name">Western Region</h3>'
          }
        },
        {
          name     : 'north-artccs',
          display  : 'artcc',
          source   : northeast,
          templates: {
            header: '<h3 class="league-name">Northeastern Region</h3>'
          }
        },
        {
          name     : 'south-artccs',
          display  : 'artcc',
          source   : southern,
          templates: {
            header: '<h3 class="league-name">Southern Region</h3>'
          }
        })
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border"><h3 class="box-title">
                        TMU Map
                    </h3></div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-4">
                            <div class="info-box" id="tmu-artcc-box">
                                <span class="info-box-icon bg-aqua"><i class="fas fa-map-marker-alt"></i></span>

                                <div class="info-box-content">

                                    <span class="info-box-text">ARTCC/Sector Selection</span>
                                    <div class="input-group info typeahead" id="artcc-search">
                                        <input id="tmu-airport" class="form-control" placeholder="ex. ZSE" value="ZSE">
                                        <span class="input-group-btn">
                                            <button class="btn btn-success" id="map-search"><i class="fas fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </div>
                    </div>
                    <iframe id="tmu-display" src="https://www.vatusa.net/tmu/ZSE"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection