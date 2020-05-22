<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordComplexity implements Rule
{

    private $contains_uppercase_letters;
    private $contains_lowercase_letters;
    private $contains_numbers;
    private $contains_symbols;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->contains_uppercase_letters = preg_match('/.*[A-ZÄÖÜ].*/', $value);
        $this->contains_lowercase_letters = preg_match('/.*[a-zäöü].*/', $value);
        $this->contains_numbers = preg_match('/.*[\d].*/', $value);
        $this->contains_symbols = preg_match('/.*[^A-zÄÖÜäöü\d].*/', $value);
        return ($this->contains_uppercase_letters + $this->contains_lowercase_letters + $this->contains_numbers + $this->contains_symbols > 3);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('passwords.password_complexity_insufficient', [
            'existing_types' =>  $this->concatTypes($this->contains_uppercase_letters,
                $this->contains_lowercase_letters, $this->contains_numbers, $this->contains_symbols),
            'missing_types' => $this->concatTypes(!$this->contains_uppercase_letters,
                !$this->contains_lowercase_letters, !$this->contains_numbers, !$this->contains_symbols)
        ]);
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
