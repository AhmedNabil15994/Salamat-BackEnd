<?php

namespace Modules\Category\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                  'title.*'     => 'required',
                  'clinic_id'   => 'required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'     => 'required',
                    'clinic_id'   => 'required',
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
            'clinic_id.required'    => __('category::dashboard.categories.validation.clinic_id.required'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {

          $v["title.".$key.".required"]  =
          __('category::dashboard.categories.validation.title.required').' - '.$value['native'].'';

        }

        return $v;

    }
}
