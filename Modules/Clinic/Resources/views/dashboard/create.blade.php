@extends('apps::dashboard.layouts.app')
@section('title', __('clinic::dashboard.clinics.routes.create'))
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
                    <a href="{{ url(route('dashboard.clinics.index')) }}">
                        {{__('clinic::dashboard.clinics.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('clinic::dashboard.clinics.routes.create')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.clinics.store')}}">
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
                                                    {{ __('clinic::dashboard.clinics.form.tabs.general') }}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#address" data-toggle="tab">
                                                    {{ __('clinic::dashboard.clinics.form.address') }}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#social_media" data-toggle="tab">
                                                    {{ __('clinic::dashboard.clinics.form.social_media') }}
                                                </a>
                                            </li>
                                            {{-- <li class="">
                                                <a href="#gallery" data-toggle="tab">
                                                    {{ __('clinic::dashboard.clinics.form.gallery') }}
                                                </a>
                                            </li> --}}
                                            <li class="">
                                                <a href="#contacts" data-toggle="tab">
                                                    {{ __('clinic::dashboard.clinics.form.contacts') }}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#availability" data-toggle="tab">
                                                    {{ __('clinic::dashboard.clinics.form.availability') }}
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

                                <h3 class="page-title">{{__('clinic::dashboard.clinics.form.tabs.general')}}</h3>

                                <div class="col-md-10">

                                    @foreach (config('translatable.locales') as $code)
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('clinic::dashboard.clinics.form.title')}} - {{ $code }}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endforeach

                                    @foreach (config('translatable.locales') as $code)
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('clinic::dashboard.clinics.form.description')}} - {{ $code }}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control {{is_rtl($code)}}Editor" data-name="description.{{$code}}"></textarea>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endforeach

                                    @foreach (config('translatable.locales') as $code)
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('clinic::dashboard.clinics.form.open_time_message')}} - {{ $code }}
                                        </label>
                                        <div class="col-md-9">
                                            <textarea dir="{{ $code === 'ar' ? 'rtl' : 'ltr' }}" name="open_time_message[{{$code}}]" rows="8" cols="80" class="form-control" data-name="open_time_message.{{$code}}"></textarea>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('clinic::dashboard.clinics.form.supplier_code')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="supplier_code" class="form-control" data-name="supplier_code">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('clinic::dashboard.clinics.form.supplier_value')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="supplier_value" class="form-control" data-name="supplier_value">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('clinic::dashboard.clinics.form.blogs_limit')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="blogs_limit" class="form-control" data-name="blogs_limit">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('clinic::dashboard.clinics.form.image')}}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a data-input="image" data-preview="holder" class="btn btn-primary lfm">
                                                        <i class="fa fa-picture-o"></i>
                                                        {{__('apps::dashboard.buttons.upload')}}
                                                    </a>
                                                </span>
                                                <input name="image" class="form-control image" type="text" readonly>
                                                <span class="input-group-btn">
                                                    <a data-input="image" data-preview="holder" class="btn btn-danger delete">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            <span class="holder" style="margin-top:15px;max-height:100px;">
                                            </span>
                                            <input type="hidden" data-name="image">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('clinic::dashboard.clinics.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('clinic::dashboard.clinics.form.is_busy')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="is_busy">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade in" id="address">
                                <h3 class="page-title">{{__('clinic::dashboard.clinics.form.address')}}</h3>
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.state') }}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="state_id" id="single" class="form-control select2-allow-clear" data-name="state_id">
                                                <option value="">Select</option>
                                                @foreach ($cities as $city)
                                                <optgroup label="{{ $city->translate(locale())->title }}">
                                                    @foreach ($city->states as $state)
                                                    <option value="{{ $state['id'] }}">
                                                        {{ $state->translate(locale())->title }}
                                                    </option>
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.lat') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="lat" class="form-control">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.lang') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="lang" class="form-control">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.block') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="block" class="form-control">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.street') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="street" class="form-control">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.building') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="building" class="form-control">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.phone_number') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="phone_number" class="form-control">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.another_phone_number') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="another_phone_number" class="form-control">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.address_details') }}
                                        </label>
                                        <div class="col-md-9">
                                            <textarea name="address_details" rows="8" cols="80" class="form-control"></textarea>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- <div class="tab-pane fade in" id="gallery">
                                <h3 class="page-title">
                                    {{__('clinic::dashboard.clinics.form.gallery')}}
                                </h3>
                                <div class="col-md-10">
                                    <div class="gallery-form">
                                    </div>
                                    <div class="get-gallery-form" style="display:none">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                            </label>
                                            <div class="input-group col-md-9">
                                                <span class="input-group-btn">
                                                    <a data-input="images" data-preview="holder" class="btn btn-primary lfm">
                                                        <i class="fa fa-picture-o"></i>
                                                        {{__('apps::dashboard.buttons.upload')}}
                                                    </a>
                                                </span>
                                                <input name="images_new[]" class="form-control images" type="text" readonly>
                                                <span class="input-group-btn">
                                                    <a data-input="images" data-preview="holder" class="btn btn-danger delete-gallery">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            <span class="holder" style="margin-top:15px;max-height:100px;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn green btn-lg mt-ladda-btn ladda-button btn-circle btn-outline add-gallery" data-style="slide-down" data-spinner-color="#333">
                                            <span class="ladda-label">
                                                <i class="icon-plus"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="tab-pane fade in" id="contacts">
                                <h3 class="page-title">
                                    {{__('clinic::dashboard.clinics.form.contacts')}}
                                </h3>
                                <div class="col-md-10">
                                    <div class="contact-form">
                                    </div>
                                    <div class="get-contact-form" style="display:none">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('clinic::dashboard.clinics.form.contact_number')}}
                                            </label>
                                            <div class="input-group col-md-9">
                                                <input name="mobile_[new][]" class="form-control" type="text">
                                                <span class="input-group-btn">
                                                    <a data-input="images" data-preview="holder" class="btn btn-danger delete-contact">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn green btn-lg mt-ladda-btn ladda-button btn-circle btn-outline add-contact" data-style="slide-down" data-spinner-color="#333">
                                            <span class="ladda-label">
                                                <i class="icon-plus"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade in" id="social_media">
                                <h3 class="page-title">
                                    {{__('clinic::dashboard.clinics.form.social_media')}}
                                </h3>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.facebook') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="social[facebook]" placeholder="https://facebook.com/user-account"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.twitter') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="social[twitter]" placeholder="https://twitter.com/user-account"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.instagram') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="social[instagram]" placeholder="https://instagram.com/user-account"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.linkedin') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="social[linkedin]" placeholder="https://linkedin.com/user-account"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('clinic::dashboard.clinics.form.youtube') }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="social[youtube]" placeholder="https://youtube.com/user-account"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade in" id="availability">
                                <h3 class="page-title">
                                    {{__('clinic::dashboard.clinics.form.availability')}}
                                </h3>
                                <div class="col-md-10">

                                    <div class="tabbable">
                                        <ul class="nav nav-tabs bg-slate nav-tabs-component">
                                            <li class="active">
                                                <a href="#colored-rounded-tab-general-opening" data-toggle="tab" aria-expanded="false">
                                                    {{__('clinic::dashboard.clinics.form.opening')}}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#colored-rounded-tab-general-days" data-toggle="tab" aria-expanded="false">
                                                    {{__('clinic::dashboard.clinics.form.days')}}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#colored-rounded-tab-general-times" data-toggle="tab" aria-expanded="false">
                                                    {{__('clinic::dashboard.clinics.form.times')}}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#colored-rounded-tab-general-dates" data-toggle="tab" aria-expanded="false">
                                                    {{__('clinic::dashboard.clinics.form.dates')}}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#colored-rounded-tab-general-custom-off" data-toggle="tab" aria-expanded="false">
                                                    {{__('clinic::dashboard.clinics.form.custom_off')}}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="colored-rounded-tab-general-opening">
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('clinic::dashboard.clinics.form.open_time')}}
                                                    <span class="required" aria-required="true">*</span>
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control 24_format" name="open_time" data-name="open_time" value="08:00">
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
                                                    {{__('clinic::dashboard.clinics.form.close_time')}}
                                                    <span class="required" aria-required="true">*</span>
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control 24_format" name="close_time" data-name="close_time" value="08:00">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-clock-o"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade in" id="colored-rounded-tab-general-days">
                                            @php
                                            $days = array('Saturday', 'Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')
                                            @endphp

                                            @foreach ($days as $key => $day)
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <div class="mt-checkbox-list">
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox" name="off_days[{{$key}}]" value="{{ strtolower($day) }}">
                                                            {{ $day }}
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control timepicker 24_format" name="day_time_from[{{ $key }}]" data-name="day_time_from[]" value="00:01">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-clock-o"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control timepicker 24_format" name="day_time_to[{{ $key }}]" data-name="day_time_to[]" value="23:59">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-clock-o"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade in" id="colored-rounded-tab-general-times">
                                            <div class="break-form">
                                                <div class="break-form-content-added"></div>
                                                <div class="break-form-content" style="display:none;">
                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('clinic::dashboard.clinics.form.times')}}
                                                        </label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control timepicker timepicker_24_format" name="time_from[]" data-name="time_from[]" value="08:00" disabled>
                                                                <span class="input-group-btn">
                                                                    <button class="btn default" type="button">
                                                                        <i class="fa fa-clock-o"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control timepicker timepicker_24_format" name="time_to[]" data-name="time_to[]" value="23:00" disabled>
                                                                <span class="input-group-btn">
                                                                    <button class="btn default" type="button">
                                                                        <i class="fa fa-clock-o"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button class="btn btn-danger remove-daily-break" type="button">
                                                                <i class="icon-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        <button type="button" class="btn btn-info add-daily-break">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade in" id="colored-rounded-tab-general-dates">

                                            <div class="dates-form">
                                                <div class="dates-form-content-added"></div>
                                                <div class="dates-form-content" style="display:none;">
                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('clinic::dashboard.clinics.form.dates')}}
                                                        </label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control datepicker" name="date_from[]" data-name="date_from[]" disabled>
                                                                <span class="input-group-btn">
                                                                    <button class="btn default" type="button">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control datepicker" name="date_to[]" data-name="date_to[]" disabled>
                                                                <span class="input-group-btn">
                                                                    <button class="btn default" type="button">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button class="btn btn-danger remove-off-dates" type="button">
                                                                <i class="icon-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        <button type="button" class="btn btn-info add-off-dates">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade in" id="colored-rounded-tab-general-custom-off">
                                            <div class="custom-off-form">
                                                <div class="custom-off-form-content-added"></div>
                                                <div class="custom-off-form-content" style="display:none;">
                                                    <div class="form-group">
                                                        <div class="col-md-3">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control custom_datepicker" name="custom_date[]" data-name="custom_date[]" disabled>
                                                                <span class="input-group-btn">
                                                                    <button class="btn default" type="button">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control timepicker custompicker_24_format" name="custom_time_from[]" data-name="custom_time_from[]" value="08:00" disabled>
                                                                <span class="input-group-btn">
                                                                    <button class="btn default" type="button">
                                                                        <i class="fa fa-clock-o"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control timepicker custompicker_24_format" name="custom_time_to[]" data-name="custom_time_to[]" value="23:00" disabled>
                                                                <span class="input-group-btn">
                                                                    <button class="btn default" type="button">
                                                                        <i class="fa fa-clock-o"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button class="btn btn-danger remove-custom-off" type="button">
                                                                <i class="icon-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">
                                                        <button type="button" class="btn btn-info add-custom-off">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </label>
                                                </div>
                                            </div>
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
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg blue">
                                    {{__('apps::dashboard.buttons.add')}}
                                </button>
                                <a href="{{url(route('dashboard.clinics.index')) }}" class="btn btn-lg red">
                                    {{__('apps::dashboard.buttons.back')}}
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
    $(function() {
        $('#jstree').jstree();
        $('#jstree').on("changed.jstree", function(e, data) {
            $('#root_category').val(data.selected);
        });
    });
</script>

<script>
    // GALLERY FORM / ADD NEW BUTTON UPLOAD
    $(document).ready(function() {
        var html = $("div.get-gallery-form").html();
        $(".add-gallery").click(function(e) {
            e.preventDefault();
            $(".gallery-form").append(html);
            $('.lfm').filemanager('image');
        });
    });

    // DELETE UPLOAD BUTTON
    $(".gallery-form").on("click", ".delete-gallery", function(e) {
        e.preventDefault();
        $(this).closest('.form-group').remove();
    });
</script>
<script>
    // CONTACT FORM / ADD NEW BUTTON UPLOAD
    $(document).ready(function() {
        var html = $("div.get-contact-form").html();
        $(".add-contact").click(function(e) {
            e.preventDefault();
            $(".contact-form").append(html);
            $('.lfm').filemanager('image');
        });
    });

    // DELETE UPLOAD BUTTON
    $(".contact-form").on("click", ".delete-contact", function(e) {
        e.preventDefault();
        $(this).closest('.form-group').remove();
    });
</script>

<script>
    $('.24_format').timepicker({
        showMeridian: true,
        format: 'hh:mm',
    });

    $('.timepicker_30_min').timepicker({
        minuteStep: 30,
        showMeridian: false,
        maxHours: 6
    });
</script>

<script>
    $(".add-daily-break").click(function() {

        var availability = $(this).closest(".break-form").find('.break-form-content').html();
        $(this).closest(".break-form").find(".break-form-content-added").append(availability);
        $(this).closest(".break-form").find(".break-form-content-added").find('.timepicker_24_format').timepicker({
            showMeridian: true,
            format: 'hh:mm',
        });

        $(this).closest(".break-form").find(".break-form-content-added").find('.timepicker_24_format').prop('disabled', false);

    });

    // DELETE UPLOAD BUTTON
    $(".break-form-content-added").on("click", ".remove-daily-break", function(e) {
        e.preventDefault();
        $(this).closest('.form-group').remove();
    });
</script>

<script>
    $(".add-off-dates").click(function() {

        var availability = $(this).closest(".dates-form").find('.dates-form-content').html();

        $(this).closest(".dates-form").find(".dates-form-content-added").append(availability);

        $(this).closest(".dates-form").find(".dates-form-content-added").find('.datepicker').datepicker({
          format: 'yyyy-mm-dd',
          startDate: '0d'
        });

        $(this).closest(".dates-form").find(".dates-form-content-added").find('.datepicker').prop('disabled', false);

    });

    // DELETE UPLOAD BUTTON
    $(".dates-form-content-added").on("click", ".remove-off-dates", function(e) {
        e.preventDefault();
        $(this).closest('.form-group').remove();
    });
</script>

<script>
    $(".add-custom-off").click(function() {

        var availability = $(this).closest(".custom-off-form").find('.custom-off-form-content').html();

        $(this).closest(".custom-off-form").find(".custom-off-form-content-added").append(availability);
        $(this).closest(".custom-off-form").find(".custom-off-form-content-added").find('.custom_datepicker').datepicker({
          format: 'yyyy-mm-dd',
          startDate: '0d'
        });

        $(this).closest(".custom-off-form").find(".custom-off-form-content-added").find('.custompicker_24_format').timepicker({
            showMeridian: true,
            format: 'hh:mm',
        });
        $(this).closest(".custom-off-form").find(".custom-off-form-content-added").find('.form-control').prop('disabled', false);

    });

    // DELETE UPLOAD BUTTON
    $(".custom-off-form-content-added").on("click", ".remove-custom-off", function(e) {
        e.preventDefault();
        $(this).closest('.form-group').remove();
    });
</script>
@stop
