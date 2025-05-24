@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.orders.calendar.title'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('order::dashboard.orders.calendar.title')}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12" style="padding:30px">
                <form role="form" class="form-horizontal form-row-seperated" method="get" enctype="multipart/form-data" action="{{ url(route('dashboard.orders.calendar')) }}">

                    {{-- <div class="form-group">
                        <label class="col-md-1">
                            {{__('order::dashboard.orders.form.doctor')}}
                        </label>
                        <div class="col-md-5">
                            <select name="doctor_id" id="single" class="form-control select2" data-name="doctor_id">
                                <option value=""></option>
                                @foreach ($doctors as $doctor)
                                <option value="{{ $doctor['id'] }}">
                                    {{ $doctor->name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="help-block"></div>
                        </div>
                    </div> --}}

                    <div class="form-group">
                        <label class="col-md-1">
                            {{__('order::dashboard.orders.form.clinic')}}
                        </label>
                        <div class="col-md-5">
                            <select name="clinic_id" id="single" class="form-control select2 clinic" data-name="clinic_id">
                                <option value=""></option>
                                @foreach ($clinics as $clinic)
                                <option value="{{ $clinic['id'] }}">
                                    {{ $clinic->translate(locale())->title }}
                                </option>
                                @endforeach
                            </select>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="view-doctors"></div>

                    <div class="col-md-12">
                        <div class="form-actions">
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn blue">
                                    {{__('apps::dashboard.buttons.filter')}}
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="row" style="margin-top: 40px;">
            <div class="col-md-12">
                <div class="portlet light portlet-fit bordered calendar">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div id="orderCalendar" class="has-toolbar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@stop

@section('scripts')

<script>
    $(document).ready(function() {

        $('#orderCalendar').fullCalendar({
            defaultView: 'agendaDay',
            selectable: true,
            defaultTimedEventDuration: '00:15:00',
            slotDuration: '00:15:00',
            slotLabelInterval: 15,
            slotLabelFormat: 'h(:mm)a',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaDay,agendaWeek',
            },
            defaultView: 'month',
            events : [
                @foreach ($orders as $order)
                {
                    title : '{{ ($order->doctor) ? $order->doctor->name : (($order->operator) ? $order->operator->name : $order->room->name) }} - {{ $order->service->translate(locale())->title }}',
                    start : '{{$order->date}} {{ $order->time_from }}',
                    end : '{{$order->date}} {{ $order->time_to }}',
                    url : '{{ route("dashboard.orders.show", $order->id) }}',
                    color  : '{{ ($order->doctor) ? '#378006' : '#ab396e'}}',
                },
                @endforeach
            ]
        })

    });
</script>

<script>
    $(document).ready(function() {
        $('.clinic').on('change', function(e) {
            var clinic_id = $(this).val();
            $.ajax({
                url: '{{url(route('dashboard.clinics.doctors2'))}}',
                type: 'GET',
                data: {
                    clinic_id: clinic_id
                },
                beforeSend: function() {},
                success: function(data) {
                    $('.view-doctors').html(data);
                    $('select').select2();
                },
                error: function(data) {
                    console.log(data);
                },
            });
        });
    });
</script>

@stop
