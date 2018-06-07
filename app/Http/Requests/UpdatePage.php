<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Page;

class UpdatePage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $course_id = $this->request->get('course_id');
        $page_id = $this->request->get('id');
        return [
            'title' => [
                'required',
                'unique:pages,title,' . $page_id . ',id,course_id,' . $course_id,
            ],
            'body' => 'required',
        ];
    }
}
