@extends('adminlte::page')

@section('title', 'Fire Hazard')

@section('content')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <div class="mt-5 pt-1">
        <h1 class="mb-4">Informações:</h1>
        <div class="row">
            <div class="col-md-3 d-flex">
                <div class="card rounded shadow-sm h-100 w-100" data-toggle="modal"
                     data-target="#user-per-interventions-chart" style="background-color: #a6c1ee; color: black;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-user"></i> Funcionários</h5>
                        <p class="card-text">Existem {{ $users->count() }} funcionários registados.</p>
                    </div>
                </div>
            </div>
            <!-- Add the same classes and styles to the other cards -->
            <div class="col-md-3 d-flex">
                <div class="card rounded shadow-sm h-100 w-100" data-toggle="modal" data-target="#veiculos"
                     style="background-color: #b2d8b2; color: black;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-car"></i> Veículos</h5>
                        <p class="card-text">Existem {{ $cars->count() }} veículos registados.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="card rounded shadow-sm h-100 w-100" style="background-color: #f5e79e; color: black;">
                    <div class="card-body" data-toggle="modal" data-target="#exampleModal">
                        <h5 class="card-title"><i class="fas fa-wrench"></i> Intervenções</h5>
                        <p class="card-text">Existem {{ $interventions->count() }} intervenções registadas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="card rounded shadow-sm h-100 w-100 no-hover-card"
                     style="background-color: #f2a29e; color: black; opacity: 40%">
                    <div class="card-body" title="Ver Intervenções por data">
                        <h5 class="card-title"><i class="fas fa-users"></i> Clientes</h5>
                        <p class="card-text">{{ $clients ? count($clients) : 0 }} clientes estão registados.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="user-per-interventions-chart" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Intervenções por Funcionário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <canvas id="user-interventions-chart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="veiculos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Veículos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <canvas id="car-interventions-chart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Intervenções</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <canvas id="line-chart" width="400" height="200"></canvas>
                    <div id="button-container" class="mt-3">
                        <h5>Ordenar por</h5>
                        <button id="all" class="btn btn-primary">Todas</button>
                        <button id="week" class="btn btn-secondary">Semana</button>
                        <button id="month" class="btn btn-secondary">Mês</button>
                        <button id="year" class="btn btn-secondary">Ano</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<script src="{{ asset('vendor/jquery/jquery.js') }}"></script>

@section('js')

    <!--Interventions-->
    <script>
        $(document).ready(function () {
            // Your JavaScript code goes here.

            var interventions = {};
            @foreach($interventions as $intervention)
            var date = "{{ $intervention->created_at->format('Y-m-d') }}";
            if (!interventions.hasOwnProperty(date)) {
                interventions[date] = 1;
            } else {
                interventions[date] += 1;
            }
            @endforeach

            var data = [];
            for (var key in interventions) {
                if (interventions.hasOwnProperty(key)) {
                    data.push({x: key, y: interventions[key]});
                }
            }

            var ctx = document.getElementById('line-chart').getContext('2d');
            var line_chart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Numero de intervenções criadas',
                        data: data,
                        borderColor: '#007bff',
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            type: 'time',
                            time: {
                                parser: 'Y-m-d',
                                tooltipFormat: 'll'
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Date'
                            }
                        }]
                    }
                }
            });

            document.getElementById('week').addEventListener('click', function () {
                updateButtonAndChart('week');
            });
            document.getElementById('month').addEventListener('click', function () {
                updateButtonAndChart('month');
            });
            document.getElementById('year').addEventListener('click', function () {
                updateButtonAndChart('year');
            });
            document.getElementById('all').addEventListener('click', function () {
                updateButtonAndChart('all');
            });

            function updateChart(timePeriod) {
                var filteredData = [];

                if (timePeriod === 'all') {
                    for (var key in interventions) {
                        if (interventions.hasOwnProperty(key)) {
                            filteredData.push({x: key, y: interventions[key]});
                        }
                    }
                } else {
                    var oneWeekAgo = new Date();
                    var oneMonthAgo = new Date();
                    var oneYearAgo = new Date();

                    oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
                    oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
                    oneYearAgo.setFullYear(oneYearAgo.getFullYear() - 1);

                    for (var key in interventions) {
                        if (interventions.hasOwnProperty(key)) {
                            var date = new Date(key);
                            if ((timePeriod === 'week' && date > oneWeekAgo) ||
                                (timePeriod === 'month' && date > oneMonthAgo) ||
                                (timePeriod === 'year' && date > oneYearAgo)) {
                                filteredData.push({x: key, y: interventions[key]});
                            }
                        }
                    }
                }

                line_chart.data.datasets[0].data = filteredData;
                line_chart.update();
            }

            function updateButtonAndChart(timePeriod) {
                var weekButton = document.getElementById('week');
                var monthButton = document.getElementById('month');
                var yearButton = document.getElementById('year');
                var allButton = document.getElementById('all');

                // Reset all buttons to secondary
                weekButton.className = 'btn btn-secondary';
                monthButton.className = 'btn btn-secondary';
                yearButton.className = 'btn btn-secondary';
                allButton.className = 'btn btn-secondary';

                // Highlight the active button
                switch (timePeriod) {
                    case 'week':
                        weekButton.className = 'btn btn-primary';
                        break;
                    case 'month':
                        monthButton.className = 'btn btn-primary';
                        break;
                    case 'year':
                        yearButton.className = 'btn btn-primary';
                        break;
                    case 'all':
                        allButton.className = 'btn btn-primary';
                        break;
                }

                updateChart(timePeriod);
            }
        });

    </script>

    <!--Cars-->
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            // Get the interventions per user data from the Blade template
            var interventionsPerCar = {!! json_encode($interventionsPerCar) !!};

            // Get the chart element
            var chartElement = document.getElementById('car-interventions-chart');

            // Create a new chart instance
            var userInterventionsChart = new Chart(chartElement, {
                type: 'bar',
                data: {
                    labels: Object.keys(interventionsPerCar),
                    datasets: [{
                        label: 'Intervenções por Veiculo',
                        data: Object.values(interventionsPerCar),
                        backgroundColor: 'rgba(0, 123, 255, 0.8)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                        hoverBackgroundColor: 'rgba(0, 123, 255, 1)'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Intervenções  por Veiculo',
                            font: {
                                size: 18
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            displayColors: false,
                            callbacks: {
                                title: function (tooltipItem) {
                                    return 'Veiculo: ' + tooltipItem[0].label;
                                },
                                label: function (tooltipItem) {
                                    var dataset = tooltipItem.datasetIndex;
                                    var index = tooltipItem.dataIndex;
                                    var value = userInterventionsChart.data.datasets[dataset].data[index];
                                    return 'Intervenções: ' + value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

    <!--Interventions per User-->
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            // Get the interventions per user data from the Blade template
            var interventionsPerUser = {!! json_encode($interventionsPerUser) !!};

            // Get the chart element
            var chartElement = document.getElementById('user-interventions-chart');

            // Create a new chart instance
            var userInterventionsChart = new Chart(chartElement, {
                type: 'bar',
                data: {
                    labels: Object.keys(interventionsPerUser),
                    datasets: [{
                        label: 'Intervenções por Funcionário',
                        data: Object.values(interventionsPerUser),
                        backgroundColor: 'rgba(0, 123, 255, 0.8)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                        hoverBackgroundColor: 'rgba(0, 123, 255, 1)'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Intervenções por Funcionário',
                            font: {
                                size: 18
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            displayColors: false,
                            callbacks: {
                                title: function (tooltipItem) {
                                    return 'Funcionário: ' + tooltipItem[0].label;
                                },
                                label: function (tooltipItem) {
                                    var dataset = tooltipItem.datasetIndex;
                                    var index = tooltipItem.dataIndex;
                                    var value = userInterventionsChart.data.datasets[dataset].data[index];
                                    return 'Intervenções: ' + value;
                                }
                            }
                        }
                    }
                }
            });
        });


    </script>

@endsection
