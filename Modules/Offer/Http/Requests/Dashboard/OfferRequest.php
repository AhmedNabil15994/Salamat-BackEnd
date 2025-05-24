<?php

namespace Modules\Offer\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
                    'title.*'           => 'required',
                    'description.*'     => 'required',
                    'price'             => 'required',
                    'clinic_id'         => 'required',
                    'service_id'        => 'required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'           => 'required',
                    'description.*'     => 'required',
                    'price'             => 'required',
                    'clinic_id'         => 'required',
                    'service_id'        => 'required',
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
            'price.required'        => __('offer::dashboard.offers.validation.price.required'),
            'clinic_id.required'    => __('offer::dashboard.offers.validation.clinic_id.required'),
            'service_id.required'   => __('offer::dashboard.offers.validation.service_id.required'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {

          $v["title.".$key.".required"]  =
          __('offer::dashboard.offers.validation.title.required').' - '.$value['native'].'';

            $v["description.".$key.".required"]  =
            __('offer::dashboard.offers.validation.description.required').' - '.$value['native'].'';

        }

        return $v;

    }
}
