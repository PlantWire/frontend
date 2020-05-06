<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHumiditySensor extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sensor_name' => 'required|alpha_num|max:255',
            'alarm_threshold' => 'nullable|integer|between:0,100',
            'notes' => 'nullable|string|max:10000',
            'measurement_interval_days' => 'nullable|integer|between:0,30',
            'measurement_interval_hours' => 'nullable|integer|between:0,23',
            'measurement_start' => 'nullable|date|after_or_equal:now',
        ];
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
