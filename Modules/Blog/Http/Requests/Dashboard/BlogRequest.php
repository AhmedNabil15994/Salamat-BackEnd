<?php

namespace Modules\Blog\Http\Requests\Dashboard;

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
                  'type_'           => 'required',
                  'clinic_id'       => 'sometimes|required',
                  'doctor_id'       => 'sometimes|required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'        => 'required',
                    'description.*'  => 'required',
                    'clinic_id'      => 'sometimes|required',
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
          __('blog::dashboard.blogs.validation.title.required').' - '.$value['native'].'';


          $v["description.".$key.".required"]  =
          __('blog::dashboard.blogs.validation.description.required').' - '.$value['native'].'';

        }

        return $v;

    }
}
