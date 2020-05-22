<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

use App\Rules\PasswordComplexity;

class UpdateUserRequest extends FormRequest
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
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'old_password' => 'nullable|password:web',
            'new_password' => ['required_with:old_password', 'confirmed', new PasswordComplexity, 'nullable'],
            'new_password_confirmation' => 'required_with:old_password|nullable',
        ];
    }
}
