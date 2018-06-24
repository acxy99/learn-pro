<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Course;
use App\File;

use App\Http\Requests\StoreFile;
use App\Http\Requests\UpdateFile;

class FileController extends Controller {

    public function index($course_slug) {
        $course = Course::findBySlugOrFail($course_slug);

        return view('admin.files.index', ['course' => $course]);
    }

    public function create($course_slug) {
        $course = Course::findBySlugOrFail($course_slug);

        return view('admin.files.create', ['course' => $course]);
    }

    public function store(StoreFile $request) {
        $files = collect(new File);

        if ($request->hasFile('files')) {
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

    public function edit($course_slug, $id) {
        $course = Course::findBySlugOrFail($course_slug);
        $file = File::findOrFail($id);

        return view('admin.files.edit', ['course' => $course, 'file' => $file]);
    }

    public function update(UpdateFile $request, $id) {
        $file = File::findOrFail($id);
        $course = Course::findOrFail($file->course_id);

        $originalFilePath = 'public/courses/' . $course->slug . '/' . $file->name;
        $originalExtension = pathinfo($originalFilePath, PATHINFO_EXTENSION);

        $includesExtension = pathinfo($request->name, PATHINFO_EXTENSION) ? true : false;

        $newFileName = $includesExtension ? $request->name : $request->name . '.' . $extension;
        $newFilePath = 'public/courses/' . $course->slug . '/' . $newFileName;

        Storage::move($originalFilePath, $newFilePath);

        $file->fill($request->all());
        $file->save();

        return response()->json(['file' => $file]);
    }

    public function destroy($id) {
        $file = File::findOrFail($id);
        $course = Course::findOrFail($file->course_id);

        Storage::delete('public/courses/' . $course->slug . '/' . $file->name);
        $file->delete();

        return response()->json(['file' => $file]);
    }
}
