@extends('apps::clinic.layouts.app')
@section('title', __('staff::clinic.staffs.create.title'))
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
                    <a href="{{ url(route('clinic.staffs.index')) }}">
                        {{__('staff::clinic.staffs.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('staff::clinic.staffs.create.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('clinic.staffs.store')}}">
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
                                                <a href="#global_setting" data-toggle="tab">
                                                    {{ __('staff::clinic.staffs.create.form.general') }}
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
                            <div class="tab-pane active fade in" id="global_setting">
                                <h3 class="page-title">{{__('staff::clinic.staffs.create.form.general')}}</h3>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('staff::clinic.staffs.create.form.name')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="name" class="form-control" data-name="name">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('staff::clinic.staffs.create.form.email')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="email" name="email" class="form-control" data-name="email">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('staff::clinic.staffs.create.form.mobile')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="mobile" class="form-control" data-name="mobile">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('staff::clinic.staffs.create.form.password')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="password" name="password" class="form-control" data-name="password">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('staff::clinic.staffs.create.form.confirm_password')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="password" name="confirm_password" class="form-control" data-name="confirm_password">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('staff::clinic.staffs.create.form.image')}}
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
                                            </span>
                                            <input type="hidden" data-name="image">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('staff::clinic.staffs.create.form.roles')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <div class="mt-checkbox-list">
                                                @foreach ($roles as $role)
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" name="roles[]" value="{{$role->id}}">
                                                    {{$role->translate(locale())->display_name}}
                                                    <span></span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
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
                                <a href="{{url(route('clinic.staffs.index')) }}" class="btn btn-lg red">
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
