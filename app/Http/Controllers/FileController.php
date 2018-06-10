<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\File;
use App\Course;
use App\Http\Requests\StoreFile;
use Validator;

class FileController extends Controller {
    
    public function index() {
        //
    }

    public function create($course_slug) {
        $course = Course::findBySlugOrFail($course_slug);

        return view('files.create', ['course' => $course]);
    }

    public function store(StoreFile $request) {

        /*$newFileNames = [];

        if($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $originalExtension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

                $newExtension = $originalExtension ? $originalExtension : $file->extension();
                $newFileName = $originalFileName . '.' . $newExtension;

                array_push($newFileNames, $newFileName);
            }
        }

        $request['file_names'] = $newFileNames;

        Validator::make($request->all(), [
            'file_names.*' => 'unique:files,name',
        ])->validate();*/

        // return response()->json(['request' => $request->all()]);

        $files = collect(new File);

        if($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                $fileModel = new File;

                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $originalExtension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

                $newExtension = $originalExtension ? $originalExtension : $file->extension();
                $newFileName = $originalFileName . '.' . $newExtension;

                $fileModel->name = $newFileName;
                $fileModel->course_id = $request->course_id;
                $fileModel->save();

                $file->storeAs('public/courses/' . $request->course_slug, $fileModel->name);

                $files->push($fileModel);
            }
        }
        
        return response()->json(['files' => $files]);
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }
}
