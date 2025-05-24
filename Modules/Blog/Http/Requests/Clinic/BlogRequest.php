<?php

namespace Modules\Blog\Http\Requests\Clinic;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
                  'title.*'         => 'required',
                  'description.*'   => 'required',
                  'type_'          => 'required',
                  'doctor_id'      => 'sometimes|required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'        => 'required',
                    'description.*'  => 'required',
                    'doctor_id'      => 'sometimes|required',
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
            'type_.required'        => __('blog::dashboard.blogs.validation.type_.required'),
            'clinic_id.required'    => __('blog::dashboard.blogs.validation.clinic_id.required'),
            'doctor_id.required'    => __('blog::dashboard.blogs.validation.doctor_id.required'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {

          $v["title.".$key.".required"]  =
          __('blog::clinic.blogs.validation.title.required').' - '.$value['native'].'';


          $v["description.".$key.".required"]  =
          __('blog::clinic.blogs.validation.description.required').' - '.$value['native'].'';

        }

        return $v;

    }
}
