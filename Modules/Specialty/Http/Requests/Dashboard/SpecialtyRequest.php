<?php

namespace Modules\Specialty\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SpecialtyRequest extends FormRequest
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
                  'title.*'         => 'required|unique:specialty_translations,title',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'          => 'required|unique:specialty_translations,title,'.$this->id.',specialty_id',
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

            $v["title.".$key.".required"]         = __('specialty::dashboard.specialties.validation.title.required').' - '.$value['native'].'';

            $v["title.".$key.".unique"]           = __('specialty::dashboard.specialties.validation.title.unique').' - '.$value['native'].'';

        }

        return $v;

    }
}
