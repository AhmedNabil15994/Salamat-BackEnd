@extends('apps::dashboard.layouts.app')
@section('title', __('offer::dashboard.offers.routes.update'))
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
                    <a href="{{ url(route('dashboard.offers.index')) }}">
                        {{__('offer::dashboard.offers.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('offer::dashboard.offers.routes.update')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.offers.update',$offer->id)}}">
                @csrf
                @method('PUT')
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
                                                <a href="#global_setting" data-toggle="tab">
                                                    {{ __('offer::dashboard.offers.form.tabs.general') }}
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

                            {{-- UPDATE FORM --}}
                            <div class="tab-pane active fade in" id="global_setting">
                                <h3 class="page-title">{{__('offer::dashboard.offers.form.tabs.general')}}</h3>

                                <div class="col-md-10">

                                    @foreach (config('translatable.locales') as $code)
                                      <div class="form-group">
                                          <label class="col-md-2">
                                              {{__('offer::dashboard.offers.form.title')}} - {{ $code }}
                                              <span class="required" aria-required="true">*</span>
                                          </label>
                                          <div class="col-md-9">
                                              <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}" value="{{ $offer->translate($code)->title }}">
                                              <div class="help-block"></div>
                                          </div>
                                      </div>
                                    @endforeach

                                    @foreach (config('translatable.locales') as $code)
                                      <div class="form-group">
                                          <label class="col-md-2">
                                              {{__('offer::dashboard.offers.form.description')}} - {{ $code }}
                                              <span class="required" aria-required="true">*</span>
                                          </label>
                                          <div class="col-md-9">
                                              <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control {{is_rtl($code)}}Editor" data-name="description.{{$code}}">{{ $offer->translate($code)->description }}</textarea>
                                              <div class="help-block"></div>
                                          </div>
                                      </div>
                                    @endforeach

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('offer::dashboard.offers.form.price') }}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="price" class="form-control" data-name="price" value="{{ $offer->price }}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('offer::dashboard.offers.form.clinics')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="clinic_id" id="single" class="form-control select2 clinic" data-name="clinic_id">
                                                <option value=""></option>
                                                @foreach ($clinics as $clinic)
                                                    <option value="{{ $clinic['id'] }}" {{ $offer->clinic_id == $clinic->id ? 'selected' : '' }}>
                                                        {{ $clinic->translate(locale())->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="view-services">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('offer::dashboard.offers.form.services')}}
                                                <span class="required" aria-required="true">*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <select name="service_id[]" id="single" class="form-control select2" data-name="service_id" multiple>
                                                    @foreach ($services as $service)
                                                    <option value="{{ $service['id'] }}" {{ $offer->services->contains($service['id']) ? 'selected' : ''}}>
                                                        {{ $service->translate(locale())->title }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('offer::dashboard.offers.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status" {{($offer->status == 1) ? ' checked="" ' : ''}}>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('offer::dashboard.offers.form.image')}}
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
                                                <img src="{{$offer->image ? url($offer->image) : ''}}" style="height: 15rem;">
                                            </span>
                                            <input type="hidden" data-name="image">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- END UPDATE FORM --}}

                        </div>
                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg green">
                                    {{__('apps::dashboard.buttons.edit')}}
                                </button>
                                <a href="{{url(route('dashboard.offers.index')) }}" class="btn btn-lg red">
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
                    url: '{{url(route('dashboard.clinics.services'))}}',
                    type: 'GET',
                    data: {
                        clinic_id: clinic_id
                    },
                    beforeSend: function () {
                    },
                    success: function (data) {
                        $('.view-services').html(data);
                        $('select').select2();
                    },
                    error: function (data) {
                        console.log(data);
                    },
                });
            });
        });
    </script>
@endsection
