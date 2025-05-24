<?php

namespace Modules\Staff\Http\Requests\Clinic;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
                  'roles'           => 'required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'name'            => 'required',
                    'mobile'          => 'required|numeric|digits_between:8,8|unique:users,mobile,'.$this->id.'',
                    'email'           => 'required|unique:users,email,'.$this->id.'',
                    'password'        => 'nullable|min:6|same:confirm_password',
                    'roles'           => 'required',
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
            'roles.required'          => __('staff::clinic.staffs.validation.roles.required'),
            'name.required'           => __('staff::clinic.staffs.validation.name.required'),
            'email.required'          => __('staff::clinic.staffs.validation.email.required'),
            'email.unique'            => __('staff::clinic.staffs.validation.email.unique'),
            'mobile.required'         => __('staff::clinic.staffs.validation.mobile.required'),
            'mobile.unique'           => __('staff::clinic.staffs.validation.mobile.unique'),
            'mobile.numeric'          => __('staff::clinic.staffs.validation.mobile.numeric'),
            'mobile.digits_between'   => __('staff::clinic.staffs.validation.mobile.digits_between'),
            'password.required'       => __('staff::clinic.staffs.validation.password.required'),
            'password.min'            => __('staff::clinic.staffs.validation.password.min'),
            'password.same'           => __('staff::clinic.staffs.validation.password.same'),
        ];

        return $v;
    }
}
