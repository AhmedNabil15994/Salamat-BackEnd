<?php

namespace Modules\Room\Http\Requests\Dashboard;

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
                  'name'            => 'required',
                  'clinic_id'       => 'required',
                  'roles'           => 'required',
                  'open_time'       => 'required|date_format:g:i A',
                  'close_time'      => 'required|date_format:g:i A|after:open_time',
            ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'name'            => 'required',
                    'clinic_id'       => 'required',
                    'roles'           => 'required',
                    'open_time'       => 'required|date_format:g:i A',
                    'close_time'      => 'required|date_format:g:i A|after:open_time',
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
            'roles.required'          => __('room::dashboard.rooms.validation.roles.required'),
            'name.required'           => __('room::dashboard.rooms.validation.name.required'),
            'roles.required'          => __('room::dashboard.rooms.validation.roles.required'),
            'open_time.required'      => __('doctor::clinic.doctors.validation.open_time.required'),
            'open_time.date_format'   => __('doctor::clinic.doctors.validation.open_time.time'),
            'close_time.required'     => __('doctor::clinic.doctors.validation.close_time.required'),
            'close_time.date_format'  => __('doctor::clinic.doctors.validation.close_time.time'),
            'close_time.after'        => __('doctor::clinic.doctors.validation.close_time.after'),
            'clinic_id.required'      => __('doctor::clinic.doctors.validation.clinic_id.required'),
        ];

        return $v;
    }
}
