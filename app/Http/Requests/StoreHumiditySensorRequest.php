<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreHumiditySensorRequest extends FormRequest
{

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
        return [
            'uuid' => 'required|uuid|unique:humidity_sensors',
            'pin' => 'required|max:9999|min:0|numeric',
            'name' => 'required|alpha_num|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'uuid' => __('unique sensor identification (UUID)'),
            'pin' => __('sensor pin'),
            'name' => __('sensor name')
        ];
    }
}
