<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'username' => 'required|unique:users|min:3|regex:/^[a-z0-9_.]*$/',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages() {
        return [
            'username.regex' => 'The username must contain only lowercase letters, numbers, periods, and underscores.',
        ];
    }
}
