<?php

namespace Modules\Service\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
                  'title.*'             => 'required',
                  'description.*'       => 'required',
                  'time_to_take'        => 'required',
                  'price'               => 'required|numeric',
                  'point_amount'        => 'nullable|lte:price|numeric',
                  'points_per_amount'   => 'nullable|required_with:point_amount|numeric',
                  'clinic_id'           => 'required',
                  'clinic_category_id'  => 'required',
                  'doctor_id'           => 'required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'             => 'required',
                    'description.*'       => 'required',
                    'time_to_take'        => 'required',
                    'price'               => 'required|numeric',
                    'point_amount'        => 'nullable|lte:price|numeric',
                    'points_per_amount'   => 'nullable|required_with:point_amount|numeric',
                    'clinic_id'           => 'required',
                    'clinic_category_id'  => 'required',
                    'doctor_id'           => 'required',
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
            'time_to_take.required'      => __('service::dashboard.services.validation.time_to_take.required'),
            'price.required'            => __('service::dashboard.services.validation.price.required'),
            'price.numeric'             => __('service::dashboard.services.validation.price.numeric'),
            'point_amount.lte'          => __('service::dashboard.services.validation.point_amount.lte'),
            'point_amount.numeric'      => __('service::dashboard.services.validation.point_amount.numeric'),
            'points_per_amount.required_with'=> __('service::dashboard.services.validation.points_per_amount.required_with'),
            'points_per_amount.numeric'     => __('service::dashboard.services.validation.points_per_amount.numeric'),
            'clinic_id.required'            => __('service::dashboard.services.validation.clinic_id.required'),
            'clinic_category_id.required'   => __('service::dashboard.services.validation.clinic_category_id.required'),
            'doctor_id.required'            => __('service::dashboard.services.validation.doctor_id.required'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {

          $v["title.".$key.".required"]  =
          __('service::dashboard.services.validation.title.required').' - '.$value['native'].'';

          $v["description.".$key.".required"]  =
          __('service::dashboard.services.validation.description.required').' - '.$value['native'].'';

        }

        return $v;

    }
}
