{{-- @extends('user.master') --}}
@extends('layout.master')
@section('content')
    <div class="card">
        {{-- <div class="card-header d-flex justify-content-between">
        <h4>Chart</h4>
    </div> --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body scroll">
            <figure class="highcharts-figure">
                <div id="container"></div>
                <p class="highcharts-description">
                    Pie chart where the individual slices can be clicked to expose more
                    detailed data.
                </p>
            </figure>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        // Create the chart
        Highcharts.chart('container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Browser market shares. January, 2022',
                align: 'left'
            },
            subtitle: {
                text: 'Click the slices to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>',
                align: 'left'
            },

            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    valueSuffix: '%'
                }
            },

            plotOptions: {
                series: {
                    borderRadius: 5,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },

            series: [{
                name: 'Browsers',
                colorByPoint: true,
                data: [{
                        name: 'Chrome',
                        y: 61.04,
                        drilldown: 'Chrome'
                    },
                    {
                        name: 'Safari',
                        y: 9.47,
                        drilldown: 'Safari'
                    },
                    {
                        name: 'Edge',
                        y: 9.32,
                        drilldown: 'Edge'
                    },
                    {
                        name: 'Firefox',
                        y: 8.15,
                        drilldown: 'Firefox'
                    },
                    {
                        name: 'Other',
                        y: 11.02,
                        drilldown: null
                    }
                ]
            }],
            drilldown: {
                series: [{
                        name: 'Chrome',
                        id: 'Chrome',
                        data: [
                            [
                                'v97.0',
                                36.89
                            ],
                            [
                                'v96.0',
                                18.16
                            ],
                            [
                                'v95.0',
                                0.54
                            ],
                            [
                                'v94.0',
                                0.7
                            ],
                            [
                                'v93.0',
                                0.8
                            ],
                            [
                                'v92.0',
                                0.41
                            ],
                            [
                                'v91.0',
                                0.31
                            ],
                            [
                                'v90.0',
                                0.13
                            ],
                            [
                                'v89.0',
                                0.14
                            ],
                            [
                                'v88.0',
                                0.1
                            ],
                            [
                                'v87.0',
                                0.35
                            ],
                            [
                                'v86.0',
                                0.17
                            ],
                            [
                                'v85.0',
                                0.18
                            ],
                            [
                                'v84.0',
                                0.17
                            ],
                            [
                                'v83.0',
                                0.21
                            ],
                            [
                                'v81.0',
                                0.1
                            ],
                            [
                                'v80.0',
                                0.16
                            ],
                            [
                                'v79.0',
                                0.43
                            ],
                            [
                                'v78.0',
                                0.11
                            ],
                            [
                                'v76.0',
                                0.16
                            ],
                            [
                                'v75.0',
                                0.15
                            ],
                            [
                                'v72.0',
                                0.14
                            ],
                            [
                                'v70.0',
                                0.11
                            ],
                            [
                                'v69.0',
                                0.13
                            ],
                            [
                                'v56.0',
                                0.12
                            ],
                            [
                                'v49.0',
                                0.17
                            ]
                        ]
                    },
                    {
                        name: 'Safari',
                        id: 'Safari',
                        data: [
                            [
                                'v15.3',
                                0.1
                            ],
                            [
                                'v15.2',
                                2.01
                            ],
                            [
                                'v15.1',
                                2.29
                            ],
                            [
                                'v15.0',
                                0.49
                            ],
                            [
                                'v14.1',
                                2.48
                            ],
                            [
                                'v14.0',
                                0.64
                            ],
                            [
                                'v13.1',
                                1.17
                            ],
                            [
                                'v13.0',
                                0.13
                            ],
                            [
                                'v12.1',
                                0.16
                            ]
                        ]
                    },
                    {
                        name: 'Edge',
                        id: 'Edge',
                        data: [
                            [
                                'v97',
                                6.62
                            ],
                            [
                                'v96',
                                2.55
                            ],
                            [
                                'v95',
                                0.15
                            ]
                        ]
                    },
                    {
                        name: 'Firefox',
                        id: 'Firefox',
                        data: [
                            [
                                'v96.0',
                                4.17
                            ],
                            [
                                'v95.0',
                                3.33
                            ],
                            [
                                'v94.0',
                                0.11
                            ],
                            [
                                'v91.0',
                                0.23
                            ],
                            [
                                'v78.0',
                                0.16
                            ],
                            [
                                'v52.0',
                                0.15
                            ]
                        ]
                    }
                ]
            }
        });
    </script>
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            max-width: 660px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
@endsection
@section('app')
    <style>
        .btn-outline-primary {
            pointer-events: none;
        }
    </style>
    <button type="button"
        class="btn btn-outline-primary mt-2">{{ session()->get('name_app') ? session()->get('name_app') : 'CGV' }} </button>
@endsection
