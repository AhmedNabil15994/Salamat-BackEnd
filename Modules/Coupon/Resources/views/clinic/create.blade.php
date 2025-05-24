@extends('apps::clinic.layouts.app')
@section('title', __('coupon::clinic.coupons.routes.create'))
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
                    <a href="{{ url(route('clinic.coupons.index')) }}">
                        {{__('coupon::clinic.coupons.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('coupon::clinic.coupons.routes.create')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('clinic.coupons.store')}}">
                @csrf
                <div class="col-md-12">

                    {{-- RIGHT SIDE --}}
                    <div class="col-md-3">
                        <div class="panel-group accordion scrollable" id="accordion2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                </div>
                                <div id="collapse_2_1" class="panel-collapse in">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li class="active">
                                                <a href="#general" data-toggle="tab">
                                                    {{ __('coupon::clinic.coupons.form.tabs.general') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PAGE CONTENT --}}
                    <div class="col-md-9">
                        <div class="tab-content">

                            {{-- CREATE FORM --}}
                            <div class="tab-pane active fade in" id="general">
                                <h3 class="page-title">{{__('coupon::clinic.coupons.form.tabs.general')}}</h3>
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('coupon::clinic.coupons.form.code') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="code" class="form-control" data-name="code">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('coupon::clinic.coupons.form.discount') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="discount" class="form-control" data-name="discount">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('coupon::clinic.coupons.form.used_times') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="used_times" class="form-control" data-name="used_times">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('coupon::clinic.coupons.form.from') }}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker" name="from" data-name="from">
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
                                            {{ __('coupon::clinic.coupons.form.to') }}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker" name="to" data-name="to">
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
                                            {{__('order::dashboard.orders.show.service')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="service_id[]" id="single" class="form-control select2" data-name="service_id" multiple>
                                                <option value=""></option>
                                                @foreach ($services as $service)
                                                <option value="{{ $service['id'] }}">
                                                    {{ $service->translate(locale())->title }} - {{ $service->clinic->translate(locale())->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('coupon::clinic.coupons.form.users')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="user_id[]" id="single" class="form-control select2" data-name="user_id" multiple>
                                                <option value=""></option>
                                                @foreach ($users as $user)
                                                <option value="{{ $user['id'] }}">
                                                    {{ $user->id }} - {{ $user->name }} - {{ $user->mobile }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('coupon::clinic.coupons.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- END CREATE FORM --}}

                        </div>
                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::clinic.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg blue">
                                    {{__('apps::clinic.buttons.add')}}
                                </button>
                                <a href="{{url(route('clinic.coupons.index')) }}" class="btn btn-lg red">
                                    {{__('apps::clinic.buttons.back')}}
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script>
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      startDate: '0d'
    });
</script>
@stop
