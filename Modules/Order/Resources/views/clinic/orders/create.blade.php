@extends('apps::clinic.layouts.app')
@section('title', __('order::clinic.orders.routes.create'))
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
                    <a href="{{ url(route('clinic.orders.index')) }}">
                        {{__('order::clinic.orders.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('order::clinic.orders.routes.create')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('clinic.orders.store')}}">
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
                                                    {{ __('order::clinic.orders.form.tabs.general') }}
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
                                <h3 class="page-title">{{__('order::clinic.orders.form.tabs.general')}}</h3>
                                <div class="col-md-10">


                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('order::clinic.orders.form.users')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="user_id" id="single" class="form-control select2" data-name="user_id">
                                                <option value=""></option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user['id'] }}">
                                                        {{ $user->id. ' - ' .$user->name. ' - ' . $user->email }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('order::clinic.orders.form.operators')}}
                                        </label>

                                        <div class="col-md-9">
                                            <select name="operator_id" id="single" class="form-control select2" data-name="operator_id">
                                                <option value=""></option>
                                                @foreach ($operators as $operator)
                                                    <option value="{{ $operator['id'] }}">
                                                        {{ $operator->id. ' - ' .$operator->name. ' - ' . $operator->email }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('order::clinic.orders.form.rooms')}}
                                        </label>

                                        <div class="col-md-9">
                                            <select name="room_id" id="single" class="form-control select2" data-name="room_id">
                                                <option value=""></option>
                                                @foreach ($rooms as $room)
                                                    <option value="{{ $room['id'] }}">
                                                        {{ $room->id. ' - ' .$room->name. ' - ' . $room->email }}
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
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="ignore_doctor">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('order::clinic.orders.form.doctors')}}
                                        </label>

                                        <div class="col-md-9">
                                            <select name="doctor_id" id="single" class="form-control select2 doctor" data-name="doctor_id">
                                                <option value=""></option>
                                                @foreach ($doctors as $doctor)
                                                    <option value="{{ $doctor['id'] }}">
                                                        {{ $doctor->id. ' - ' .$doctor->name. ' - ' . $doctor->email }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="view-services"></div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('order::clinic.orders.form.total')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="total" class="form-control total_price" data-name="total">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('order::dashboard.orders.show.time_from')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control 24_format" name="time_from" data-name="time_from" autocomplete="false">
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
                                                <input type="text" class="form-control 24_format" name="time_to" data-name="time_to" autocomplete="false">
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
                                                <input type="text" class="form-control datepicker" name="date" data-name="date" autocomplete="false">
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
                                            {{__('order::clinic.orders.form.is_paid')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="is_paid">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="service_price" class="service_price" value="">

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
                                <a href="{{url(route('clinic.orders.index')) }}" class="btn btn-lg red">
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
        $('.doctor').on('change', function(e) {
            var doctor_id = $(this).val();
            $.ajax({
                url: '{{ url(route('clinic.doctors.services')) }}',
                type: 'GET',
                data: {
                    doctor_id: doctor_id
                },
                beforeSend: function() {},
                success: function(data) {
                    $('.view-services').html(data);
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
    $('.24_format').timepicker({
        showMeridian: true,
        format: 'hh:mm',
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d'
    });
</script>


<script>
$(document).ready(function() {
    $('.select_service').on('change', function(e) {
        var price = $(this).find(':selected').attr('data-price');
        $('.service_price').val(price);
        $('.total_price').val(price);
    });
});
</script>

@endsection
