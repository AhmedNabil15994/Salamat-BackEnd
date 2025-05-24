<div class="form-group">
    <label class="col-md-2">
        {{__('service::dashboard.services.form.categories')}}
        <span class="required" aria-required="true">*</span>
    </label>
    <div class="col-md-9">
        <select name="clinic_category_id" id="single" class="form-control select2" data-name="clinic_category_id">
            <option value="">Select</option>
            @foreach ($clinic->categories as $category)
            <option value="{{ $category['id'] }}">
                {{ $category->translate(locale())->title }}
            </option>
            @endforeach
        </select>
        <div class="help-block"></div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2">
        {{__('service::dashboard.services.form.doctors')}}
        <span class="required" aria-required="true">*</span>
    </label>
    <div class="col-md-9">
        <select name="doctor_id" id="single" class="form-control select2" data-name="doctor">
            <option value="">Select</option>
            @foreach ($clinic->doctors as $doctor)
            <option value="{{ $doctor['id'] }}">
                {{ $doctor->name }}
            </option>
            @endforeach
        </select>
        <div class="help-block"></div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2">
        {{__('service::dashboard.services.form.operators')}}
    </label>
    <div class="col-md-9">
        <select name="operator_id[]" id="single" class="form-control select2" data-name="operator_id" multiple>
            @foreach ($clinic->operators as $operator)
            <option value="{{ $operator['id'] }}">
                {{ $operator->name }}
            </option>
            @endforeach
        </select>
        <div class="help-block"></div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2">
        {{__('service::dashboard.services.form.rooms')}}
    </label>
    <div class="col-md-9">
        <select name="room_id[]" id="single" class="form-control select2" data-name="room_id" multiple>
            @foreach ($clinic->rooms as $room)
            <option value="{{ $room['id'] }}">
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
        <input type="checkbox" class="make-switch" id="test" data-size="small" name="ignore_doctor">
        <div class="help-block"></div>
    </div>
</div>
