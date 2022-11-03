<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => ['required','string','email:rfc,dns','max:255'],
            'password' => ['required','string', Password::min(6)->letters()->numbers()],
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }

    public static function getRules()
    {
        $these = new static;
        return $these->rules();
    }

    public static function getMessages()
    {
        $these = new static;
        return $these->messages();
    }
}
