<?php

namespace Modules\Operator\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class OperatorRequest extends FormRequest
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
                  'mobile'          => 'required|numeric|unique:users,mobile|digits_between:8,8',
                  'email'           => 'required|unique:users,email',
                  'password'        => 'required|min:6|same:confirm_password',
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
                    'mobile'          => 'required|numeric|digits_between:8,8|unique:users,mobile,'.$this->id.'',
                    'email'           => 'required|unique:users,email,'.$this->id.'',
                    'password'        => 'nullable|min:6|same:confirm_password',
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
            'name.required'           => __('operator::dashboard.operators.validation.name.required'),
            'email.required'          => __('operator::dashboard.operators.validation.email.required'),
            'email.unique'            => __('operator::dashboard.operators.validation.email.unique'),
            'mobile.required'         => __('operator::dashboard.operators.validation.mobile.required'),
            'mobile.unique'           => __('operator::dashboard.operators.validation.mobile.unique'),
            'mobile.numeric'          => __('operator::dashboard.operators.validation.mobile.numeric'),
            'mobile.digits_between'   => __('operator::dashboard.operators.validation.mobile.digits_between'),
            'password.required'       => __('operator::dashboard.operators.validation.password.required'),
            'password.min'            => __('operator::dashboard.operators.validation.password.min'),
            'password.same'           => __('operator::dashboard.operators.validation.password.same'),
            'roles.required'          => __('operator::dashboard.operators.validation.roles.required'),
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
