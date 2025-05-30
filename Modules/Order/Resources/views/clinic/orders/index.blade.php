@extends('apps::clinic.layouts.app')
@section('title', __('order::clinic.orders.index.title'))
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
                    <a href="#">{{__('order::clinic.orders.index.title')}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">


                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ url(route('clinic.orders.create')) }}" class="btn sbold green">
                                        <i class="fa fa-plus"></i> {{__('apps::clinic.buttons.add_new')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DATATABLE FILTER --}}
                    <div class="row">
                        <div class="portlet box grey-cascade">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>
                                    {{__('apps::clinic.datatable.search')}}
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="expand" data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body portlet-collapsed">
                                <div id="filter_data_table">
                                    <div class="panel-body">
                                        <form id="formFilter" class="horizontal-form">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('apps::clinic.datatable.form.date_range')}}
                                                            </label>
                                                            <div id="reportrange" class="btn default form-control">
                                                                <i class="fa fa-calendar"></i> &nbsp;
                                                                <span> </span>
                                                                <b class="fa fa-angle-down"></b>
                                                                <input type="hidden" name="from">
                                                                <input type="hidden" name="to">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('order::clinic.orders.datatable.status')}}
                                                            </label>
                                                            <select name="status_id" id="single" class="form-control">
                                                                <option value="">
                                                                    {{__('apps::clinic.datatable.form.select')}}
                                                                </option>
                                                                @foreach ($statuses as $status)
                                                                <option value="{{ $status['id'] }}">
                                                                    {{ $status->translate(locale())->title }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('order::clinic.orders.datatable.users')}}
                                                            </label>
                                                            <select name="user_id" id="single" class="form-control select2">
                                                                <option value="">
                                                                    {{__('apps::clinic.datatable.form.select')}}
                                                                </option>
                                                                @foreach ($users as $user)
                                                                <option value="{{ $user['id'] }}">
                                                                    {{ $user->id }} - {{ $user->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('order::clinic.orders.datatable.services')}}
                                                            </label>
                                                            <select name="service_id" id="single" class="form-control select2">
                                                                <option value="">
                                                                    {{__('apps::clinic.datatable.form.select')}}
                                                                </option>
                                                                @foreach ($services as $service)
                                                                <option value="{{ $service['id'] }}">{{ $service->translate(locale())->title }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('order::clinic.orders.datatable.operators')}}
                                                            </label>
                                                            <select name="operator_id" id="single" class="form-control select2">
                                                                <option value="">
                                                                    {{__('apps::clinic.datatable.form.select')}}
                                                                </option>
                                                                @foreach ($operators as $operator)
                                                                <option value="{{ $operator['id'] }}">
                                                                    {{ $operator->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="form-actions">
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom" id="search">
                                                <i class="fa fa-search"></i>
                                                {{__('apps::clinic.datatable.search')}}
                                            </button>
                                            <button class="btn btn-sm red btn-outline filter-cancel">
                                                <i class="fa fa-times"></i>
                                                {{__('apps::clinic.datatable.reset')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END DATATABLE FILTER --}}

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">
                                {{__('order::clinic.orders.index.title')}}
                            </span>
                        </div>
                    </div>

                    {{-- DATATABLE CONTENT --}}
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="javascript:;" onclick="CheckAll()">
                                            {{__('apps::clinic.buttons.select_all')}}
                                        </a>
                                    </th>
                                    <th>{{__('order::dashboard.orders.datatable.id')}}</th>
                                    <th>{{__('order::clinic.orders.datatable.operators')}}</th>
                                    <th>{{__('order::clinic.orders.datatable.doctor')}}</th>
                                    <th>{{__('order::clinic.orders.datatable.service')}}</th>
                                    <th>{{__('order::clinic.orders.datatable.user')}}</th>
                                    <th>{{__('order::clinic.orders.datatable.date')}}</th>
                                    <th>{{__('order::clinic.orders.datatable.time_from')}}</th>
                                    <th>{{__('order::clinic.orders.datatable.time_to')}}</th>
                                    <th>{{__('order::clinic.orders.datatable.total')}} - {{ setting('default_currency') }}</th>
                                    <th>{{__('order::clinic.orders.datatable.status')}}</th>
                                    <th>{{__('order::clinic.orders.datatable.method')}}</th>
                                    <th>{{__('order::clinic.orders.datatable.created_at')}}</th>
                                    <th>{{__('order::clinic.orders.datatable.options')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <button type="submit" id="deleteChecked" class="btn red btn-sm" onclick="deleteAllChecked('{{ url(route('clinic.orders.deletes')) }}')">
                                {{__('apps::clinic.datatable.delete_all_btn')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')

<script>
    function tableGenerate(data = '') {

        var dataTable =
            $('#dataTable').DataTable({
                ajax: {
                    url: "{{ url(route('clinic.orders.datatable')) }}",
                    type: "GET",
                    data: {
                        req: data,
                    },
                },
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
                },
                stateSave: true,
                processing: true,
                serverSide: true,
                responsive: !0,
                order: [
                    [1, "desc"]
                ],
                columns: [
                    {
                        data: 'id',className: 'dt-center'
                    },
                    {
                        data: 'id',className: 'dt-center'
                    },
                    {
                        data: 'operator_id',className: 'dt-center' ,orderable: false
                    },
                    {
                        data: 'doctor',className: 'dt-center' ,orderable: false
                    },
                    {
                        data: 'service',className: 'dt-center' ,orderable: false
                    },
                    {
                        data: 'user',className: 'dt-center' ,orderable: false
                    },
                    {
                        data: 'date',className: 'dt-center'
                    },
                    {
                        data: 'time_from',className: 'dt-center'
                    },
                    {
                        data: 'time_to',className: 'dt-center'
                    },
                    {
                        data: 'total',className: 'dt-center'
                    },
                    {
                        data: 'order_status_id',className: 'dt-center'
                    },
                    {
                        data: 'transaction',className: 'dt-center',orderable: false
                    },
                    {
                        data: 'created_at',
                        className: 'dt-center'
                    },
                    {
                        data: 'id'
                    },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '30px',
                        className: 'dt-center',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="` + data + ` class="group-checkable" name="ids">
                          <span></span>
                        </label>
                      `;
                        },
                    },
                    {
                        targets: -1,
                        width: '13%',
                        title: '{{__('order::clinic.orders.datatable.options')}}',
                        className: 'dt-center',
                        orderable: false,
                        render: function(data, type, full, meta) {

                            // Show
                            var showUrl = '{{ route("clinic.orders.show", ":id") }}';
                            showUrl = showUrl.replace(':id', data);

                            return `
          						<a href="` + showUrl + `" class="btn btn-sm btn-warning" title="Show">
          			              <i class="fa fa-eye"></i>
          			            </a>
                            `;

                        },
                    },
                ],
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 25, 50, 100, 500],
                    ['10', '25', '50', '100', '500']
                ],
                buttons: [{
                        extend: "pageLength",
                        className: "btn blue btn-outline",
                        text: "{{__('apps::clinic.datatable.pageLength')}}",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: "print",
                        className: "btn blue btn-outline",
                        text: "{{__('apps::clinic.datatable.print')}}",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: "pdf",
                        className: "btn blue btn-outline",
                        text: "{{__('apps::clinic.datatable.pdf')}}",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: "excel",
                        className: "btn blue btn-outline ",
                        text: "{{__('apps::clinic.datatable.excel')}}",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: "colvis",
                        className: "btn blue btn-outline",
                        text: "{{__('apps::clinic.datatable.colvis')}}",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    }
                ]
            });
    }

    jQuery(document).ready(function() {
        tableGenerate();
    });
</script>

@stop
