<?php

namespace Modules\Coupon\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod())
        {
            // handle creates
            case 'post':
            case 'POST':

                return [
                  'code'        => 'required',
                  'discount'    => 'required|numeric|min:1|max:99',
                  'from'        => 'required',
                  'to'          => 'required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                  'code'        => 'required',
                  'discount'    => 'required|numeric|min:1|max:99',
                  'from'        => 'required',
                  'to'          => 'required',
                ];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'code.required'         => 'Please add coupon code',
            'discount.numeric'      => 'Please enter discount as digits only',
            'discount.required'     => 'Please add the discount %',
            'discount.min'          => 'discount must be more than 1 %',
            'discount.max'          => 'discount must be less than 100%',
            'from.required'         => 'Please select from date',
            'to.required'           => 'Please select to date',
        ];

        return $v;

    }
}
