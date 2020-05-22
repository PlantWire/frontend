<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => 'password:web',
            'new_password' => 'required_with:old_password|confirmed',
            'new_password_confirmation' => 'required_with:old_password',
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
            if ($this->has('new_password') && !$this->input('new_password') == 0) {
                $contains_uppercase_letters = preg_match('/.*[A-ZÄÖÜ].*/', $this->input('new_password'));
                $contains_lowercase_letters = preg_match('/.*[a-zäöü].*/', $this->input('new_password'));
                $contains_numbers = preg_match('/.*[\d].*/', $this->input('new_password'));
                $contains_symbols = preg_match('/.*[^A-zÄÖÜäöü\d].*/', $this->input('new_password'));
                if($contains_uppercase_letters + $contains_lowercase_letters + $contains_numbers + $contains_symbols
                < 3) {
                    $missing_types = __('passwords.password_complexity_insufficient', [
                        'existing_types' =>  $this->concatTypes($contains_uppercase_letters,
                            $contains_lowercase_letters, $contains_numbers, $contains_symbols),
                        'missing_types' => $this->concatTypes(!$contains_uppercase_letters,
                            !$contains_lowercase_letters, !$contains_numbers, !$contains_symbols)
                    ]);
                    $validator->errors()->add('new_password',  $missing_types);
                }
            }
        });
    }

    private function concatTypes($uppercase_letters, $lowercase_letters, $numbers, $symbols) {
        $types = '';
        if($uppercase_letters) {
             $types = $types . __('uppercase letters') . ', ';
        }
        if($lowercase_letters) {
             $types = $types . __('lowercase letters') . ', ';
        }
        if($numbers) {
             $types = $types . __('numbers') . ', ';
        }
        if($symbols) {
             $types = $types . __('symbols') . ', ';
        }
        $types = substr($types, 0, -2);
        $search = ', ';
        $pos = strrpos($types, $search);
        if($pos !== false)
        {
            $types = substr_replace($types, __(' and '), $pos, strlen($search));
        }
        return $types;
    }
}
