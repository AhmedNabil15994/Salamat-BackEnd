<?php

namespace Modules\Category\Http\Requests\Clinic;

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
                  'title.*'  => 'required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*' => 'required',
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

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {

          $v["title.".$key.".required"]  =
          __('category::clinic.categories.validation.title.required').' - '.$value['native'].'';

        }

        return $v;

    }
}
