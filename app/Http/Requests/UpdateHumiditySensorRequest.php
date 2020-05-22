<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateHumiditySensorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'sensor_name' => 'required|alpha_num|max:255',
            'alarm_threshold' => 'nullable|integer|between:0,100',
            'notes' => 'nullable|string|max:10000',
            'measurement_interval_days' => 'nullable|integer|between:0,30',
            'measurement_interval_hours' => 'nullable|integer|between:0,23',
            'measurement_start' => 'nullable|date|after_or_equal:now',
        ];
        return $rules;
    }


    /**
     * Make additional conditional validation
     *
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ((!$this->has('measurement_interval_days') || $this->input('measurement_interval_days') == 0)
                && (!$this->has('measurement_interval_hours') || $this->input('measurement_interval_hours') == 0)) {
                $validator->errors()->add('measurement_interval_hours', __('validation.not_both_zero_or_empty', [
                    'first' =>  __('Measurement Interval days'),
                    'second' => __('Measurement Interval hours')
                ]));
            }
        });
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'sensor_name' => 'Sensor Name',
            'alarm_threshold' => 'Alarm Threshold',
            'notes' => 'Notes',
            'measurement_interval_days' => 'Measurement Interval days',
            'measurement_interval_hours' => 'Measurement Interval hours',
            'measurement_start' => 'Measurement Start Time',
         ];
    }
}
