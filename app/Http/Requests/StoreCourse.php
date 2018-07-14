<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourse extends FormRequest {
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'code' => 'required|unique:courses',
            'title' => 'required',
            'description'  => 'required',
            'owner_id' => 'required',
        ];
    }

    public function messages() {
        return [
            'owner_id.required' => 'The owner field is required.',
        ];
    }
}
