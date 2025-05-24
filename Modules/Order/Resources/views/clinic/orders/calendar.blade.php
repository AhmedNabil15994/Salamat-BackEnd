@extends('apps::clinic.layouts.app')
@section('title', __('order::clinic.orders.calendar.title'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('clinic.home')) }}">{{ __('apps::clinic.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('order::clinic.orders.calendar.title')}}</a>
                </li>
            </ul>
        </div>

        @permission('clinic_access')
        <div class="row">
            <div class="col-md-12" style="padding:30px">
                <form role="form" class="form-horizontal form-row-seperated" method="get" enctype="multipart/form-data" action="{{ url(route('clinic.orders.calendar')) }}">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-2">
                                    {{ __('order::dashboard.orders.form.doctor') }}
                                </label>
                                <div class="col-md-9">
                                    <select name="doctor_id" id="single" class="form-control select2" data-name="doctor_id">
                                        <option value="">
                                            {{__('apps::clinic.datatable.form.select')}}
                                        </option>
                                        @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor['id'] }}">
                                            {{ $doctor->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2">
                                    {{__('order::clinic.orders.form.users')}}
                                </label>
                                <div class="col-md-9">
                                    <select name="user_id" id="single" class="form-control select2">
                                        <option value="">
                                            {{__('apps::clinic.datatable.form.select')}}
                                        </option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user['id'] }}">
                                            {{ $user->id }} - {{ $user->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-2">
                                    {{__('order::clinic.orders.datatable.services')}}
                                </label>
                                <div class="col-md-9">
                                    <select name="service_id" id="single" class="form-control select2">
                                        <option value="">
                                            {{__('apps::clinic.datatable.form.select')}}
                                        </option>
                                        @foreach ($services as $service)
                                        <option value="{{ $service['id'] }}">{{ $service->translate(locale())->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2">
                                    {{__('order::clinic.orders.datatable.operators')}}
                                </label>
                                <div class="col-md-9">
                                    <select name="operator_id" id="single" class="form-control select2">
                                        <option value="">
                                            {{__('apps::clinic.datatable.form.select')}}
                                        </option>
                                        @foreach ($operators as $operator)
                                        <option value="{{ $operator['id'] }}">
                                            {{ $operator->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

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
        @endpermission

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
                    url : '{{ route("clinic.orders.show", $order->id) }}',
                    color  : '{{ ($order->doctor) ? '#378006' : '#ab396e'}}',
                },
                @endforeach
            ]
        })

    });
</script>

@stop
