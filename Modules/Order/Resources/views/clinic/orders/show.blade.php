@extends('apps::clinic.layouts.app')
@section('title', __('order::clinic.orders.show.title'))
@section('content')
  <style type="text/css" media="print">
  	@page {
  		size  : auto;
  		margin: 0;
  	}
  	@media print {
  		a[href]:after {
  		content: none !important;
  	}
  	.contentPrint{
  			width: 100%;
  		}
  		.no-print, .no-print *{
  			display: none !important;
  		}
  	}
  </style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('clinic.home')) }}">{{ __('apps::clinic.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('clinic.orders.index')) }}">
                        {{__('order::clinic.orders.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('order::clinic.orders.show.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <div class="col-md-12">
                <div class="no-print">
                    <div class="col-md-3">
                        <ul class="ver-inline-menu tabbable margin-bottom-10">
                            <li class="active">
                                <a data-toggle="tab" href="#order">
                                    <i class="fa fa-cog"></i> {{__('order::clinic.orders.show.invoice')}}
                                </a>
                                <span class="after"></span>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#transactions">
                                    <i class="fa fa-cog"></i> {{__('transaction::clinic.orders.show.transactions')}}
                                </a>
                                <span class="after"></span>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#update">
                                    <i class="fa fa-cog"></i> {{__('order::dashboard.orders.show.update')}}
                                </a>
                                <span class="after"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 contentPrint">
                    <div class="tab-content">


                            <div class="tab-pane active" id="order">
                                <div class="invoice-content-2 bordered">

                                    <div class="col-md-12" style="margin-bottom: 24px;">
                                        <center>
                                            <img src="{{ url(setting('logo')) }}" class="img-responsive" style="width:18%" />
                                            <b>
                                                #{{ $order['id'] }} -
                                                {{ date('Y-m-d / H:i:s' , strtotime($order->created_at)) }}
                                            </b>
                                        </center>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.username')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.email')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.mobile')}}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold"> {{ $order->user->name }}</td>
                                                        <td class="text-center sbold"> {{ $order->user->email }}</td>
                                                        <td class="text-center sbold"> {{ $order->user->mobile }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">

                                            <div class="col-xs-12 table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="invoice-title uppercase text-center">
                                                                #
                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                {{__('order::dashboard.orders.show.service')}}
                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                {{__('order::dashboard.orders.show.date')}}
                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                {{__('order::dashboard.orders.show.time')}}
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center sbold"> {{ $order->service->id }} </td>
                                                            <td class="text-center sbold">
                                                                {{ $order->service->translate(locale())->title }}
                                                            </td>
                                                            <td class="text-center sbold"> {{ $order->date }} </td>
                                                            <td class="text-center sbold">
                                                                {{ $order->time_from }} - {{ $order->time_to }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.doctor')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.operator')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.room')}}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold">
                                                            {{ $order->doctor ? $order->doctor->name  : ''}}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->operator ? $order->operator->name  : ''}}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->room ? $order->room->name  : ''}}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.order.subtotal')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.order.off')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.order.total')}}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold">
                                                            {{ $order->subtotal }} {{ setting('default_currency') }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->discount }} {{ setting('default_currency') }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->total }} {{ setting('default_currency') }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        <div class="tab-pane" id="transactions">
                            <div class="invoice">
                                <div class="row invoice-logo">
                                    <div class="col-xs-6">
                                        <p>
                                            <img src="{{ url(setting('favicon')) }}" class="img-responsive" style="width:40%" />
                                        </p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p> #{{ $order->transactions ? $order->transactions->payment_id : '' }} /
                                            {{ date('Y-m-d',strtotime($order->created_at)) }}
                                        </p>
                                    </div>
                                </div>

                                <hr />

                                <div class="row">
                                    <h3>{{__('transaction::dashboard.orders.show.transactions')}}</h3>
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('transaction::dashboard.orders.show.transaction.payment_id')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('transaction::dashboard.orders.show.transaction.track_id')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('transaction::dashboard.orders.show.transaction.method')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('transaction::dashboard.orders.show.transaction.result')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('transaction::dashboard.orders.show.transaction.ref')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('transaction::dashboard.orders.show.transaction.tran_id')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center sbold"> {{ $order->transactions ? $order->transactions->payment_id : ''}}</td>
                                                    <td class="text-center sbold"> {{ $order->transactions ? $order->transactions->track_id : ''}}</td>
                                                    <td class="text-center sbold"> {{ $order->transactions ? $order->transactions->method : ''}}</td>
                                                    <td class="text-center sbold"> {{ $order->transactions ? $order->transactions->result : ''}}</td>
                                                    <td class="text-center sbold"> {{ $order->transactions ? $order->transactions->ref : ''}}</td>
                                                    <td class="text-center sbold"> {{ $order->transactions ? $order->transactions->tran_id : ''}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane" id="update">
                            <form id="updateForm" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{ route('clinic.orders.update',$order['id']) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label class="col-md-2">
                                        {{__('order::dashboard.orders.show.time_from')}}
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control 24_format" name="time_from" data-name="time_from" value="{{ $order->time_from }}" autocomplete="false">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-clock-o"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2">
                                        {{__('order::dashboard.orders.show.time_to')}}
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control 24_format" name="time_to" data-name="time_to" value="{{ $order->time_to }}" autocomplete="false">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-clock-o"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2">
                                        {{__('order::dashboard.orders.show.date')}}
                                    </label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" name="date" data-name="date" autocomplete="false" value="{{ $order->date }}">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2">
                                        {{__('order::dashboard.orders.show.status')}}
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <select name="status_id" id="single" class="form-control select2" data-name="status_id">
                                            <option value=""></option>
                                            @foreach ($statuses as $status)
                                            <option value="{{ $status['id'] }}" {{ $order->order_status_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->translate(locale())->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block"></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-actions">
                                        @include('apps::dashboard.layouts._ajax-msg')
                                        <div class="form-group">
                                            <button type="submit" id="submit" class="btn btn-lg green">
                                                {{__('apps::dashboard.buttons.edit')}}
                                            </button>
                                            <a href="{{url(route('dashboard.orders.index')) }}" class="btn btn-lg red">
                                                {{__('apps::dashboard.buttons.back')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
                        {{__('apps::clinic.buttons.print')}}
                        <i class="fa fa-print"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')

<script>
    $('.24_format').timepicker({
        showMeridian: true,
        format: 'hh:mm',
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d'
    });
</script>

@stop
