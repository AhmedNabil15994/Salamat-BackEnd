<?php

namespace Modules\Room\Http\Requests\Clinic;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
                  'roles'           => 'required',
                  'name'            => 'required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'roles'           => 'required',
                    'name'            => 'required',
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
            'roles.required'          => __('room::clinic.rooms.validation.roles.required'),
            'name.required'           => __('room::clinic.rooms.validation.name.required'),
        ];

        return $v;
    }
}
