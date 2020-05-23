<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

use App\HumiditySensor;

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
            'uuid' => 'required|uuid',
            'pin' => 'required|max:9999|min:0|numeric',
            'name' => 'required|alpha_num|max:255',
        ];
    }

    /**
     * Make additional conditional validation
     *
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if($this->request->has('uuid')
              && HumiditySensor::where('uuid', $this->input('uuid'))->count() != 0) {
                $validator->errors()->add('uuid', __('validation.unique', [
                    'attribute' =>  __('uuid')
                ]));
            }
        });
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
