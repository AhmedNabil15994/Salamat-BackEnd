@extends('apps::clinic.layouts.app')
@section('title', __('apps::clinic.index.title'))
@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('clinic.home')) }}">
                        {{ __('apps::clinic.index.title') }}
                    </a>
                </li>
            </ul>
        </div>
        <h1 class="page-title"> {{ __('apps::clinic.index.welcome') }} ,
            <small>
                <b style="color:red">
                    {{ auth()->user()->name }}
                </b>
            </small>
        </h1>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                    <div class="visual">
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{$countDoctors}}">0</span>
                        </div>
                        <div class="desc">{{ __('apps::clinic.index.statistics.count_doctors') }}</div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 yellow" href="#">
                    <div class="visual">
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{$countOperators}}">0</span>
                        </div>
                        <div class="desc">{{ __('apps::clinic.index.statistics.count_operators') }}</div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                    <div class="visual">
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{$countRooms}}">0</span>
                        </div>
                        <div class="desc">{{ __('apps::clinic.index.statistics.count_rooms') }}</div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{$completeOrders}}">0</span>
                        </div>
                        <div class="desc">{{ __('apps::clinic.index.statistics.comleted_orders') }}</div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{$totalProfit}}">0</span> KWD
                        </div>
                        <div class="desc">{{ __('apps::clinic.index.statistics.total_completed_orders') }}</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">
                                {{ __('apps::clinic.index.statistics.title') }}
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="mt-element-card mt-card-round mt-element-overlay">
                            <div class="row">
                                <div class="general-item-list">

                                    <div class="col-md-6">
                                        <b class="page-title">
                                            {{ __('apps::clinic.index.statistics.orders_monthly') }}
                                            - KWD
                                        </b>
                                        <canvas id="monthlyOrders" width="540" height="270"></canvas>
                                    </div>

                                    <div class="col-md-6">
                                        <b class="page-title">
                                          {{ __('apps::clinic.index.statistics.orders_status') }}
                                        </b>
                                        <canvas id="orderStatus" width="540" height="270"></canvas>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@stop


{{-- JQUERY++ --}}
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

<script>

    var ctx = document.getElementById("monthlyOrders");
    var labels = {!!$monthlyOrders['orders_dates'] !!};
    var count = {!!$monthlyOrders['profits'] !!};
    var data = {
        labels: labels,
        datasets: [{
            label: "{{ __('apps::clinic.index.statistics.orders_monthly') }}",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "#36A2EB",
            borderColor: "#36A2EB",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "#36A2EB",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "#36A2EB",
            pointHoverBorderColor: "#FFCE56",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: count,
            spanGaps: false,
        }]
    };
    var myLineChart = new Chart(ctx, {
        type: 'line',
        label: labels,
        data: data,
        options: {
            animation: {
                animateScale: true
            }
        }
    });

    var ctx = document.getElementById("orderStatus").getContext('2d');
    var orders = {!!$ordersType['ordersType'] !!};
    var ordersCount = {!!$ordersType['ordersCount'] !!};
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: orders,
            datasets: [{
                backgroundColor: [
                    "#2ea0ee",
                    "#34495e",
                    "#f2c500",
                    "#2ac6d4",
                    "#e74c3c",
                ],
                data: ordersCount
            }]
        }
    });
</script>
@stop
