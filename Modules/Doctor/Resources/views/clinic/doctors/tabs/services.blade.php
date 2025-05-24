<div class="form-group">
    <label class="col-md-2">
        {{__('offer::dashboard.offers.form.services')}}
    </label>
    <div class="col-md-9">
        <select name="service_id" id="single" class="form-control select2 select_service" data-name="service_id">
            <option value="">Select</option>
            @foreach ($doctor->services as $service)
            <option value="{{ $service['id'] }}"  data-price="{{ $service['price'] }}">
            {{ $service->id }}  -  {{ $service->translate(locale())->title }}
            </option>
            @endforeach
        </select>
        <div class="help-block"></div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('.select_service').on('change', function(e) {
        var price = $(this).find(':selected').attr('data-price');
        $('.service_price').val(price);
        $('.total_price').val(price);
    });
});
</script>
