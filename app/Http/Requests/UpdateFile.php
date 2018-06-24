<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFile extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        $course_id = $this->request->get('course_id');
        $file_id = $this->request->get('id');

        return [
            'name' => [
                'required',
                'unique:files,name,' . $file_id . ',id,course_id,' . $course_id,
            ],
        ];
    }
}
