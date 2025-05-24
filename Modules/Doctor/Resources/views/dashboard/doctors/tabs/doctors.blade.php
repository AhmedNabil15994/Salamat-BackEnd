<div class="form-group">
    <label class="col-md-1">
        {{ __('order::dashboard.orders.form.doctor') }}
    </label>
    <div class="col-md-5">
        <select name="doctor_id" id="single" class="form-control select2" data-name="doctor_id">
            <option value="">select doctor</option>
            @foreach ($clinic->doctors as $doctor)
            <option value="{{ $doctor['id'] }}">
                {{ $doctor->name }}
            </option>
            @endforeach
        </select>
        <div class="help-block"></div>
    </div>
</div>
