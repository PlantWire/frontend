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
            'measurement_interval_years' => 'nullable|integer|between:0,99',
            'measurement_interval_months' => 'nullable|integer|between:0,11',
            'measurement_interval_days' => 'nullable|integer|between:0,30',
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
            'measurement_interval_years' => 'Measurement Interval Years',
            'measurement_interval_months' => 'Measurement Interval Months',
            'measurement_interval_days' => 'Measurement Interval Days',
            'measurement_start' => 'Measurement Start Time',
         ];
    }
}
