<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-md-2">
                {{ __('order::dashboard.orders.form.doctor') }}
            </label>
            <div class="col-md-9">
                <select name="doctor_id" id="single" class="form-control select2" data-name="doctor_id">
                    <option value="">
                        {{__('apps::clinic.datatable.form.select')}}
                    </option>
                    @foreach ($clinic->doctors as $doctor)
                    <option value="{{ $doctor['id'] }}">
                        {{ $doctor->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{__('order::clinic.orders.form.users')}}
            </label>
            <div class="col-md-9">
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
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="col-md-2">
                {{__('order::clinic.orders.datatable.services')}}
            </label>
            <div class="col-md-9">
                <select name="service_id" id="single" class="form-control select2">
                    <option value="">
                        {{__('apps::clinic.datatable.form.select')}}
                    </option>
                    @foreach ($clinic->services as $service)
                    <option value="{{ $service['id'] }}">{{ $service->translate(locale())->title }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{__('order::clinic.orders.datatable.operators')}}
            </label>
            <div class="col-md-9">
                <select name="operator_id" id="single" class="form-control select2">
                    <option value="">
                        {{__('apps::clinic.datatable.form.select')}}
                    </option>
                    @foreach ($clinic->operators as $operator)
                    <option value="{{ $operator['id'] }}">
                        {{ $operator->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
