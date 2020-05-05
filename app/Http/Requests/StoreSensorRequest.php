<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreSensorRequest extends FormRequest
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
            'uuid' => array('required', 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i'),
            'pin' => 'required|max:9999|min:0|numeric',
            'name' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'uuid' => __('unique sensor identification (UUID)'),
            'pin' => __('sensor pin'),
            'name' => __('name')
        ];
    }
}
