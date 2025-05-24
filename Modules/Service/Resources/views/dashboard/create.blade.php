@extends('apps::dashboard.layouts.app')
@section('title', __('service::dashboard.services.routes.create'))
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
                        <a href="{{ url(route('dashboard.services.index')) }}">
                            {{__('service::dashboard.services.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('service::dashboard.services.routes.create')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.services.store')}}">
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
                                                        {{ __('service::dashboard.services.form.tabs.general') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#details" data-toggle="tab">
                                                        {{ __('service::dashboard.services.form.tabs.details') }}
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
                                    <h3 class="page-title">{{__('service::dashboard.services.form.tabs.general')}}</h3>
                                    <div class="col-md-10">

                                        <div class="form-group">

                                            <div class="tabbable">
                                                <ul class="nav nav-tabs bg-slate nav-tabs-component">
                                                    @foreach (config('translatable.locales') as $index => $code)
                                                        <li class=" {{ $index == 0 ? 'active' : '' }}">
                                                            <a href="#colored-rounded-tab-general-{{$code}}" data-toggle="tab" aria-expanded="false"> {{ $code }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="tab-content">
                                                @foreach (config('translatable.locales') as $index=>$code)
                                                    <div class="tab-pane fade in {{  $index == 0 ? 'active' : '' }}" id="colored-rounded-tab-general-{{$code}}">

                                                        <div class="form-group">
                                                            <label class="col-md-2">
                                                                {{__('service::dashboard.services.form.title')}} - {{ $code }}
                                                                <span class="required" aria-required="true">*</span>
                                                            </label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}">
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-2">
                                                                {{__('service::dashboard.services.form.description')}} - {{ $code }}
                                                                <span class="required" aria-required="true">*</span>
                                                            </label>
                                                            <div class="col-md-9">
                                                                <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control {{is_rtl($code)}}Editor" data-name="description.{{$code}}"></textarea>
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('service::dashboard.services.form.time_to_take')}}
                                                <span class="required" aria-required="true">*</span>
                                            </label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control timepicker_15_min" name="time_to_take" value="0:15" autocomplete="off">
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
                                                {{__('service::dashboard.services.form.price')}}
                                                <span class="required" aria-required="true">*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="price" class="form-control" data-name="price">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('service::dashboard.services.form.point_amount')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="point_amount" class="form-control" data-name="point_amount" placeholder="0.000">
                                                <b>
                                                    <small style="color:red">empty = it will not give points</small>
                                                </b>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('service::dashboard.services.form.points_per_amount')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="points_per_amount" class="form-control" data-name="points_per_amount" placeholder="0">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('service::dashboard.services.form.image')}}
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
                                                {{__('service::dashboard.services.form.status')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small" name="status">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('service::dashboard.services.form.hidden')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small" name="hidden">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('service::dashboard.services.form.is_consultation')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small" name="is_consultation">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>



                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="details">
                                    <h3 class="page-title">{{__('service::dashboard.services.form.tabs.details')}}</h3>
                                    <div class="col-md-10">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('service::dashboard.services.form.clinics')}}
                                                <span class="required" aria-required="true">*</span>
                                            </label>
                                            <div class="col-md-9">
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

                                        <div class="view-details"></div>

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
                                    <a href="{{url(route('dashboard.services.index')) }}" class="btn btn-lg red">
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

        $(document).ready(function () {
            $('.clinic').on('change', function (e) {

                var clinic_id = $(this).val();

                $.ajax({
                    url: '{{url(route('dashboard.clinics.details'))}}',
                    type: 'GET',
                    data: {
                        clinic_id: clinic_id
                    },
                    beforeSend: function () {
                    },
                    success: function (data) {
                        $('.view-details').html(data);
                        $('select').select2();
                    },
                    error: function (data) {
                        console.log(data);
                    },
                });
            });
        });
    </script>
    <script>
        $('.timepicker_15_min').timepicker({
            minuteStep: 15,
            showMeridian: false,
            maxHours: 6
        });
    </script>
@endsection
