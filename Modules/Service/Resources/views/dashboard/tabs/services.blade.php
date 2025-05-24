<div class="form-group">
    <label class="col-md-2">
        {{__('offer::dashboard.offers.form.services')}}
    </label>
    <div class="col-md-9">
        <select name="service_id[]" id="single" class="form-control select2" data-name="service_id" multiple>
            @foreach ($clinic->services as $service)
            <option value="{{ $service['id'] }}">
                {{ $service->id }}  -  {{ $service->translate(locale())->title }}
            </option>
            @endforeach
        </select>
        <div class="help-block"></div>
    </div>
</div>
