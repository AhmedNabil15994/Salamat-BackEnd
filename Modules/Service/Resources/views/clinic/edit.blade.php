@extends('apps::clinic.layouts.app')
@section('title', __('service::clinic.services.routes.update'))
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
                    <a href="{{ url(route('clinic.services.index')) }}">
                        {{__('service::clinic.services.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('service::clinic.services.routes.update')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('clinic.services.update',$service->id)}}">
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
                                                    {{ __('service::clinic.services.form.tabs.general') }}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#details" data-toggle="tab">
                                                    {{ __('service::clinic.services.form.tabs.details') }}
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
                                <h3 class="page-title">{{__('service::clinic.services.form.tabs.general')}}</h3>
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
                                                            {{__('service::clinic.services.form.title')}} - {{ $code }}
                                                            <span class="required" aria-required="true">*</span>
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}" value="{{ $service->translate($code)->title }}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('service::clinic.services.form.description')}} - {{ $code }}
                                                            <span class="required" aria-required="true">*</span>
                                                        </label>
                                                        <div class="col-md-9">
                                                            <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control {{is_rtl($code)}}Editor" data-name="description.{{$code}}">{{ $service->translate($code)->description }}</textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('service::clinic.services.form.time_to_take')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control timepicker_15_min" name="time_to_take" value="{{ $service->service_take_time }}" autocomplete="off">
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
                                            {{__('service::clinic.services.form.price')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="price" class="form-control" data-name="price" value="{{ $service->price }}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('service::dashboard.services.form.point_amount')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="point_amount" class="form-control" data-name="point_amount" value="{{ $service->points ? $service->points->amount : '' }}" placeholder="20.000">
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
                                            <input type="text" name="points_per_amount" class="form-control" data-name="points_per_amount" value="{{ $service->points ? $service->points->points_per_amount : '' }}" placeholder="5">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('service::clinic.services.form.image')}}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a data-input="image" data-preview="holder" class="btn btn-primary lfm">
                                                        <i class="fa fa-picture-o"></i>
                                                        {{__('apps::clinic.buttons.upload')}}
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
                                                <img src="{{$service->image ? url($service->image) : ''}}" style="height: 15rem;">
                                            </span>
                                            <input type="hidden" data-name="image">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('service::clinic.services.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status" {{($service->status == 1) ? ' checked="" ' : ''}}>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('service::clinic.services.form.hidden')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="hidden" {{($service->hidden == 1) ? ' checked="" ' : ''}}>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('service::clinic.services.form.is_consultation')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="is_consultation" {{($service->is_consultation==1)?' checked="" ': ''}}>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    @if ($service->trashed())
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('area::clinic.update.form.restore')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="restore">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>


                            <div class="tab-pane fade in" id="details">
                                <h3 class="page-title">{{__('service::clinic.services.form.tabs.details')}}</h3>
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('service::clinic.services.form.clinics')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="clinic_id" id="single" class="form-control select2 clinic" data-name="clinic_id">
                                                <option value=""></option>
                                                @foreach ($clinics as $cl)
                                                <option value="{{ $cl['id'] }}" {{ ($service->clinic_id == $cl->id) ? 'selected' : '' }}>
                                                    {{ $cl->translate(locale())->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="view-details">

                                      <div class="form-group">
                                          <label class="col-md-2">
                                              {{__('service::clinic.services.form.categories')}}
                                              <span class="required" aria-required="true">*</span>
                                          </label>
                                          <div class="col-md-9">
                                              <select name="clinic_category_id" id="single" class="form-control select2" data-name="clinic_category_id">
                                                  <option value="">Select</option>
                                                  @foreach ($clinic->categories as $category)
                                                  <option value="{{ $category['id'] }}"  {{ ($service->category_id == $category->id) ? 'selected' : '' }}>
                                                      {{ $category->translate(locale())->title }}
                                                  </option>
                                                  @endforeach
                                              </select>
                                              <div class="help-block"></div>
                                          </div>
                                      </div>

                                      <div class="form-group">
                                          <label class="col-md-2">
                                              {{__('service::clinic.services.form.doctors')}}
                                              <span class="required" aria-required="true">*</span>
                                          </label>
                                          <div class="col-md-9">
                                              <select name="doctor_id" id="single" class="form-control select2" data-name="doctor">
                                                  <option value="">Select</option>
                                                  @foreach ($clinic->doctors as $doctor)
                                                  <option value="{{ $doctor['id'] }}"  {{ ($service->doctor->doctor_id == $doctor->id) ? 'selected' : '' }}>
                                                      {{ $doctor->name }}
                                                  </option>
                                                  @endforeach
                                              </select>
                                              <div class="help-block"></div>
                                          </div>
                                      </div>

                                      <div class="form-group">
                                          <label class="col-md-2">
                                              {{__('service::clinic.services.form.operators')}}
                                          </label>
                                          <div class="col-md-9">
                                              <select name="operator_id[]" id="single" class="form-control select2" data-name="operator_id" multiple>
                                                  @foreach ($clinic->operators as $operator)
                                                  <option value="{{ $operator['id'] }}" {{ $service->operators->contains($operator->id) ? 'selected=""' : ''}}>
                                                      {{ $operator->name }}
                                                  </option>
                                                  @endforeach
                                              </select>
                                              <div class="help-block"></div>
                                          </div>
                                      </div>

                                      <div class="form-group">
                                          <label class="col-md-2">
                                              {{__('service::clinic.services.form.rooms')}}
                                          </label>
                                          <div class="col-md-9">
                                              <select name="room_id[]" id="single" class="form-control select2" data-name="room_id" multiple>
                                                  @foreach ($clinic->rooms as $room)
                                                  <option value="{{ $room['id'] }}" {{ $service->rooms->contains($room->id) ? 'selected=""' : ''}}>
                                                      {{ $room->name }}
                                                  </option>
                                                  @endforeach
                                              </select>
                                              <div class="help-block"></div>
                                          </div>
                                      </div>

                                      <div class="form-group">
                                          <label class="col-md-2">
                                              {{__('service::dashboard.services.form.ignore_doctor')}}
                                          </label>
                                          <div class="col-md-9">
                                              <input type="checkbox" class="make-switch" id="test" data-size="small" name="ignore_doctor" {{($service->ignore_doctor == 1) ? ' checked="" ' : ''}}>
                                              <div class="help-block"></div>
                                          </div>
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
                            @include('apps::clinic.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg green">
                                    {{__('apps::clinic.buttons.edit')}}
                                </button>
                                <a href="{{url(route('clinic.services.index')) }}" class="btn btn-lg red">
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

    $(document).ready(function() {
        $('.clinic').on('change', function(e) {

            var clinic_id = $(this).val();

            $.ajax({
                url: '{{url(route('clinic.clinics.details'))}}',
                type: 'GET',
                data: {
                    clinic_id: clinic_id
                },
                beforeSend: function() {
                },
                success: function(data) {
                  $('.view-details').html(data);
                  $('select').select2();
                },
                error: function(data) {
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
