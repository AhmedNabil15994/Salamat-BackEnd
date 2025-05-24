@extends('apps::clinic.layouts.app')
@section('title', __('blog::clinic.blogs.routes.update'))
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
                    <a href="{{ url(route('clinic.blogs.index')) }}">
                        {{__('blog::clinic.blogs.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('blog::clinic.blogs.routes.update')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('clinic.blogs.update',$blog->id)}}">
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
                                                    {{ __('blog::clinic.blogs.form.tabs.general') }}
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
                                <h3 class="page-title">{{__('blog::clinic.blogs.form.tabs.general')}}</h3>
                                <div class="col-md-10">

                                    @foreach (config('translatable.locales') as $code)
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('blog::clinic.blogs.form.title')}} - {{ $code }}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}" value="{{ $blog->translate($code)->title }}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endforeach

                                    @foreach (config('translatable.locales') as $code)
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('blog::clinic.blogs.form.description')}} - {{ $code }}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control {{is_rtl($code)}}Editor" data-name="description.{{$code}}">{{ $blog->translate($code)->description }}</textarea>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('blog::dashboard.blogs.form.video')}}
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="video" class="form-control" data-name="video" value="{{ $blog->video }}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    
                                    @if($blog->blogable_type  == 'Modules\Doctor\Entities\Doctor')
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('blog::clinic.blogs.form.doctors')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="doctor_id" id="single" class="form-control select2" data-name="user_id">
                                                <option value=""></option>
                                                @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor['id'] }}" {{ ($blog->blogable_id == $doctor->id) ? 'selected' : '' }}>
                                                    {{ $doctor->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($blog->blogable_type  == 'Modules\Clinic\Entities\Clinic')
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('blog::clinic.blogs.form.doctors')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="clinic_id" id="single" class="form-control select2" data-name="user_id">
                                                <option value=""></option>
                                                @foreach ($clinics as $clinic)
                                                <option value="{{ $clinic['id'] }}" {{ ($blog->blogable_id == $clinic->id) ? 'selected' : '' }}>
                                                    {{ $clinic->translate(locale())->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('blog::clinic.blogs.form.image')}}
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
                                                <img src="{{$blog->image ? url($blog->image) : ''}}" style="height: 15rem;">
                                            </span>
                                            <input type="hidden" data-name="image">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('blog::clinic.blogs.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status" {{($blog->status == 1) ? ' checked="" ' : ''}}>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    @if ($blog->trashed())
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
                                <a href="{{url(route('clinic.blogs.index')) }}" class="btn btn-lg red">
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
