@extends('apps::dashboard.layouts.app')
@section('title', __('offer::dashboard.booked_offers.show.title'))
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
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.booked_offers.index')) }}">
                        {{__('offer::dashboard.booked_offers.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('offer::dashboard.booked_offers.show.title')}}</a>
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
                                <a data-toggle="tab" href="#offer">
                                    <i class="fa fa-cog"></i> {{__('offer::dashboard.booked_offers.show.invoice')}}
                                </a>
                                <span class="after"></span>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#transactions">
                                    <i class="fa fa-cog"></i> {{__('transaction::dashboard.booked_offers.show.transactions')}}
                                </a>
                                <span class="after"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 contentPrint">
                    <div class="tab-content">
                        <div class="tab-pane active" id="offer">
                            <div class="invoice-content-2 boffered">
                                <div class="row invoice-head">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="row invoice-logo">
                                            <div class="col-xs-6">
                                                <img src="{{ url(setting('favicon')) }}" class="img-responsive" style="width:40%" />
                                                <span>
                                                    {{ $offer->orderStatus->translate(locale())->title }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <div class="company-address">
                                            <h6 class="uppercase">#{{ $offer['id'] }}</h6>
                                            <h6 class="uppercase">{{date('Y-m-d / H:i:s' , strtotime($offer->created_at))}}</h6>
                                            <span class="bold">
                                                {{__('offer::dashboard.booked_offers.show.from')}} :
                                            </span>
                                            {{ $offer->user->name}}
                                            <br />
                                            <span class="bold">
                                                {{__('offer::dashboard.booked_offers.show.mobile')}} :
                                            </span>
                                            {{ $offer->user->mobile }}
                                            <br />
                                        </div>
                                    </div>
                                    <div class="row invoice-body">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('offer::dashboard.booked_offers.show.total')}}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center notbold">
                                                            {{ $offer->total }} {{ setting('default_currency') }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <thead>
                                            </table>
                                        </div>
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
                                        <p> #{{ $offer->transactions->payment_id }} /
                                            {{ date('Y-m-d',strtotime($offer->created_at)) }}
                                        </p>
                                    </div>
                                </div>

                                <hr />

                                <div class="row">
                                    <h3>{{__('transaction::dashboard.booked_offers.show.transactions')}}</h3>
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('transaction::dashboard.booked_offers.show.transaction.payment_id')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('transaction::dashboard.booked_offers.show.transaction.track_id')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('transaction::dashboard.booked_offers.show.transaction.method')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('transaction::dashboard.booked_offers.show.transaction.result')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('transaction::dashboard.booked_offers.show.transaction.ref')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('transaction::dashboard.booked_offers.show.transaction.tran_id')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center sbold"> {{ $offer->transactions->payment_id}}</td>
                                                    <td class="text-center sbold"> {{ $offer->transactions->track_id }}</td>
                                                    <td class="text-center sbold"> {{ $offer->transactions->method }}</td>
                                                    <td class="text-center sbold"> {{ $offer->transactions->result }}</td>
                                                    <td class="text-center sbold"> {{ $offer->transactions->ref }}</td>
                                                    <td class="text-center sbold"> {{ $offer->transactions->tran_id }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
                        {{__('apps::dashboard.buttons.print')}}
                        <i class="fa fa-print"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
