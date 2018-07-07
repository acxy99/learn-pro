<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest {
   
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'phone' => 'nullable|regex:/^([0-9]{2,3})\-([0-9]{6,8})$/'
        ];
    }

    public function messages() {
        return [
            'phone.regex' => 'The phone number format is invalid',
        ];
    }
}
