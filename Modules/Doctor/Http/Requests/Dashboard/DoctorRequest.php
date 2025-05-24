<?php

namespace Modules\Doctor\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
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
                    'about.*'         => 'required',
                    'job_title.*'     => 'required',
                    'specialty_id'    => 'required',
                    'open_time'       => 'required|date_format:g:i A',
                    'close_time'      => 'required|date_format:g:i A|after:open_time',

                    'open_time_message'      => 'sometimes|array',
                    'open_time_message.*'    => 'sometimes|nullable|string',

                    'social'      => 'sometimes|array',
                    'social.*'      => [
                        'sometimes',
                        'nullable',
                        'string',
                        // 'url',
                        function ($attribute, $value, $fail) {
                            return (
                                $value === '#'
                                || filter_var($value, FILTER_VALIDATE_URL)
                            )
                                ? true
                                : $fail(
                                    __('doctor::clinic.doctors.validation.social.url')
                                );
                        },
                    ],
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'name'            => 'required',
                    'mobile'          => 'required|numeric|digits_between:8,8|unique:users,mobile,' . $this->id . '',
                    'email'           => 'required|unique:users,email,' . $this->id . '',
                    'password'        => 'nullable|min:6|same:confirm_password',
                    'clinic_id'       => 'required',
                    'roles'           => 'required',
                    'about.*'         => 'required',
                    'job_title.*'     => 'required',
                    'specialty_id'    => 'required',
                    'open_time'       => 'required|date_format:g:i A',
                    'close_time'      => 'required|date_format:g:i A|after:open_time',

                    'open_time_message'      => 'sometimes|array',
                    'open_time_message.*'    => 'sometimes|nullable|string',

                    'social'      => 'sometimes|array',
                    'social.*'      => [
                        'sometimes',
                        'nullable',
                        'string',
                        // 'url',
                        function ($attribute, $value, $fail) {
                            return (
                                $value === '#'
                                || filter_var($value, FILTER_VALIDATE_URL)
                            )
                                ? true
                                : $fail(
                                    __('doctor::clinic.doctors.validation.social.url')
                                );
                        },
                    ],
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
            'specialty_id.required'   => __('doctor::clinic.doctors.validation.specialty_id.required'),
            'clinic_id.required'      => __('doctor::clinic.doctors.validation.clinic_id.required'),
            'roles.required'          => __('doctor::clinic.doctors.validation.roles.required'),
            'name.required'           => __('doctor::clinic.doctors.validation.name.required'),
            'email.required'          => __('doctor::clinic.doctors.validation.email.required'),
            'email.unique'            => __('doctor::clinic.doctors.validation.email.unique'),
            'mobile.required'         => __('doctor::clinic.doctors.validation.mobile.required'),
            'mobile.unique'           => __('doctor::clinic.doctors.validation.mobile.unique'),
            'mobile.numeric'          => __('doctor::clinic.doctors.validation.mobile.numeric'),
            'mobile.digits_between'   => __('doctor::clinic.doctors.validation.mobile.digits_between'),
            'password.required'       => __('doctor::clinic.doctors.validation.password.required'),
            'password.min'            => __('doctor::clinic.doctors.validation.password.min'),
            'password.same'           => __('doctor::clinic.doctors.validation.password.same'),
            'open_time.required'      => __('doctor::clinic.doctors.validation.open_time.required'),
            'open_time.date_format'   => __('doctor::clinic.doctors.validation.open_time.time'),
            'close_time.required'     => __('doctor::clinic.doctors.validation.close_time.required'),
            'close_time.date_format'  => __('doctor::clinic.doctors.validation.close_time.time'),
            'close_time.after'        => __('doctor::clinic.doctors.validation.close_time.after'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["job_title." . $key . ".required"]  = __('doctor::clinic.doctors.validation.job_title.required') .
            ' - ' . $value['native'] . '';


            $v["about." . $key . ".required"]  = __('doctor::clinic.doctors.validation.about.required') .
            ' - ' . $value['native'] . '';
        }

        return $v;
    }
}
