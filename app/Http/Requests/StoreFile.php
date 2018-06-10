<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFile extends FormRequest {
    
    public function authorize() {
        return true;
    }

    protected function prepareForValidation() {
        $request = $this->all();

        if ($this->file('files')) {
            $newFileNames = [];
    
            foreach($this->file('files') as $file) {
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $originalExtension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

                if ($originalFileName == 'null') {
                    $newFileName = '';
                } else {
                    $newExtension = $originalExtension ? $originalExtension : $file->extension();
                    $newFileName = $originalFileName . '.' . $newExtension;
                }

                array_push($newFileNames, $newFileName);
            }

            $request['file_names'] = $newFileNames;
        }
    
        $this->replace($request);
    }

    public function rules() {
        $course_id = $this->request->get('course_id');
        
        return [
            'files' => 'required',
            'file_names.*' => 'required|distinct|unique:files,name,NULL,id,course_id,' . $course_id,
        ];
    }

    public function messages() {
        return [
            'files.required' => 'Please provide files to be uploaded',
            'file_names.*.required' => 'Please provide a file name',
            'file_names.*.distinct' => 'Please do not use the same name for multiple files',
            'file_names.*.unique' => 'This file name has already been taken',
        ];
    }
}
