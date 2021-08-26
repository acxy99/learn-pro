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
        $topic_id = $this->request->get('topic_id');

        return [
            'name' => [
                'required',
                'unique:files,name,' . $file_id . ',id,topic_id,' . $topic_id,
            ],
            'topic_id' => 'required',
        ];
    }
}
