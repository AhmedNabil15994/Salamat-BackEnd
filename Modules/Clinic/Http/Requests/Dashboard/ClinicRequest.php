<?php

namespace Modules\Clinic\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ClinicRequest extends FormRequest
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
                    'title.*'         => 'required|unique:clinic_translations,title',
                    'description.*'   => 'required',
                    'blogs_limit'     => 'required|numeric',
                    'state_id'        => 'required',
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

            // handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'        => 'required|unique:clinic_translations,title,' . $this->id . ',clinic_id',
                    'description.*'  => 'required',
                    'blogs_limit'    => 'required|numeric',
                    'state_id'       => 'required',
                    'open_time'      => 'required|date_format:g:i A',
                    'close_time'     => 'required|date_format:g:i A|after:open_time',

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
            'blogs_limit.required'  => __('clinic::dashboard.clinics.validation.blogs_limit.required'),
            'blogs_limit.numeric'   => __('clinic::dashboard.clinics.validation.blogs_limit.numeric'),
            'state_id.required'     => __('clinic::dashboard.clinics.validation.state_id.required'),
            'open_time.required'    => __('clinic::dashboard.clinics.validation.open_time.required'),
            'open_time.date_format' => __('clinic::dashboard.clinics.validation.open_time.time'),
            'close_time.required'   => __('clinic::dashboard.clinics.validation.close_time.required'),
            'close_time.date_format' => __('clinic::dashboard.clinics.validation.close_time.time'),
            'close_time.after'      => __('clinic::dashboard.clinics.validation.close_time.after'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"]  = __('clinic::dashboard.clinics.validation.title.required') .
            ' - ' . $value['native'] . '';

            $v["title." . $key . ".unique"]    = __('clinic::dashboard.clinics.validation.title.unique') .
            ' - ' . $value['native'] . '';

            $v["description." . $key . ".required"]  = __('clinic::dashboard.clinics.validation.description.required') .
            ' - ' . $value['native'] . '';
        }

        return $v;
    }
}
