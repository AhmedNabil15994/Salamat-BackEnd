@extends('apps::clinic.layouts.app')
@section('title', __('category::clinic.categories.routes.sorting'))
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
                    <a href="{{ url(route('clinic.categories.index')) }}">
                        {{__('category::clinic.categories.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('category::clinic.categories.routes.sorting')}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">

                  <div class="row">
                      <div class="profile-content">
                          <div class="portlet light">
                              <div class="portlet-body">
                                  <ul id="sortable" class="dd-list">
                                      @foreach ($categories as $clinic => $clinicCategories)

                                          <b>{{ $clinic }}</b>

                                          @foreach ($clinicCategories as $category)
                                              <li id="category-{{$category->id}}" class="dd-item">
                                                  <div class="dd-handle"> {{$category->translate(locale())->title}}</div>
                                              </li>
                                          @endforeach
                                          <hr><br>

                                      @endforeach
                                  </ul>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-actions">
                              @include('apps::clinic.layouts._ajax-msg')
                              <div class="form-group">
                                  <button type="button" id="submit" class="btn btn-lg blue re_order">
                                      {{__('apps::clinic.buttons.sorting')}}
                                  </button>
                                  <a href="{{url(route('clinic.categories.index')) }}" class="btn btn-lg red">
                                      {{__('apps::clinic.buttons.back')}}
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@stop


@section('scripts')

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <script>
      $('.re_order').on('click', function(e) {

          var data = $('#sortable').sortable('serialize');

          $.ajax({

              url: '{{url(route('clinic.categories.store.sorting'))}}',
              type: 'GET',
              dataType: 'JSON',
              data:  data,
              contentType: false,
              cache: false,
              processData:false,
              success:function(data){
                  if (data[0] == true){
                      toastr["success"](data[1]);
                  }else{
                      console.log(data);
                      toastr["error"](data[1]);
                  }
              },
             error: function(data){
                  console.log(data);
              },
          });

      });

      $(document).ready(function () {
        $('#sortable').sortable();
      });
  </script>
@stop
