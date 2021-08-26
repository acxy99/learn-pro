<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopic extends FormRequest
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
        return [
            'title' => 'required',
            'difficulity' => 'required',
            'custom_index' => 'required|numeric|min:1|unique:topics,custom_index,course_id' . $course_id
        ];
    }
}
