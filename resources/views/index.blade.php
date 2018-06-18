{{-- Extends Layout --}}
@extends('layouts.master')

{{-- Page Title --}}
@section('page-title', 'Dashboard')

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection

{{-- Header Extras to be Included --}}
@section('head-extras')
    @parent
@endsection

@section('content')
    <script>
      function dynamicColors () {
        var r = Math.floor(Math.random() * 255)
        var g = Math.floor(Math.random() * 255)
        var b = Math.floor(Math.random() * 255)
        return 'rgba(' + r + ',' + g + ',' + b + ', 0.5)'
      }

      function poolColors (a) {
        var pool = []
        for (i = 0; i < a; i++) {
          pool.push(dynamicColors())
        }
        return pool
      }
    </script>

    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>36</h3>
                    <p>Controllers Online</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-people-outline"></i>
                </div>
                <a href="info" class="small-box-footer">Controller Info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>413</h3>
                    <p>Pilots Online</p>
                </div>
                <div class="icon">
                    <i class="ion ion-plane"></i>
                </div>
                <a href="flights" class="small-box-footer">Flight Plans <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>KSEA</h3>
                    <p>Busiest Airport</p>
                </div>
                <div class="icon">
                    <i class="fas fa-signal"></i>
                </div>
                <a href="/info/KSEA" class="small-box-footer">Controller Info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>8</h3>
                    <p>Restrictions</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="restrictions" class="small-box-footer">View Restrictions <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Movements per Hour</h3>
                    <p class="text-muted">Past 8 hours</p>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="mixedChart" style="height: 250px; width: 510px;" width="510" height="250"></canvas>
                        <script>
                          var ctx = document.getElementById('mixedChart')

                          var myChart = new Chart(ctx, {
                            type   : 'bar',
                            data   : {
                              labels  : [10, 11, 12, 13, 14, 15, 16],
                              datasets: [
                                {
                                  label: 'Total controllers',
                                  data : [19, 10, 10, 11, 15, 19, 23],
                                  type : 'line'
                                },
                                {
                                  label          : 'ZSE',
                                  data           : [15, 19, 10, 11, 40, 20, 10],
                                  backgroundColor: '#D6E9C6',
                                },
                                {
                                  label          : 'ZAU',
                                  data           : [30, 8, 8, 5, 10, 19, 27],
                                  backgroundColor: '#FAEBCC',
                                },
                                {
                                  label          : 'ZLA',
                                  data           : [30, 22, 25, 29, 22, 40, 34],
                                  backgroundColor: '#EBCCD1',
                                },
                              ]
                            },
                            options: {
                              scales: {
                                xAxes: [{stacked: true}],
                                yAxes: [{stacked: true}]
                              }
                            }
                          })</script>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Movements per ARTCC</h3>
                    <p class="text-muted">Updated 5 minutes ago</p>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="pieChart" style="height: 250px; width: 510px;" width="510" height="250"></canvas>
                        <script>
                          new Chart(document.getElementById('pieChart'), {
                            type: 'doughnut',
                            data: {
                              labels  : ['ZLA', 'ZSE', 'ZMP', 'ZAN', 'HCF', 'ZAU', 'ZBW', 'ZTL', 'ZKC', 'ZHU'],
                              datasets: [{
                                label          : 'Movements',
                                data           : [15, 50, 49, 35, 14, 5, 10, 19, 30, 38],
                                backgroundColor: poolColors(10)
                              }]
                            }
                          })
                        </script>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Future Movements</h3>
                </div>
                <div class="box-body">
                    <canvas id="lineChart" style="height: 250px; width: 510px;" width="510" height="250"></canvas>
                    <script>
                      new Chart(document.getElementById('lineChart'), {
                        type   : 'line',
                        data   : {
                          labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                          datasets: [{
                            label      : 'ZSE',
                            data       : [65, 59, 80, 81, 56, 55, 40],
                            fill       : 'origin',
                            borderColor: poolColors(1)[0],
                            lineTension: 0.1
                          },
                            {
                              label      : 'ZLA',
                              data       : [29, 19, 40, 11, 76, 5, 30],
                              fill       : 'origin',
                              borderColor: poolColors(1)[0],
                              lineTension: 0.1
                            },
                            {
                              label      : 'ZAB',
                              data       : [11, 19, 20, 10, 46, 25, 10],
                              fill       : 'origin',
                              borderColor: poolColors(1)[0],
                              lineTension: 0.1
                            },
                            {
                              label      : 'ZBW',
                              data       : [41, 29, 12, 33, 12, 32, 12],
                              fill       : 'origin',
                              borderColor: poolColors(1)[0],
                              lineTension: 0.1
                            }]
                        },
                        options: {}
                      })
                    </script>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')

@endsection
