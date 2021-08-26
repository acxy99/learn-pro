<?php

namespace App\Http\Controllers\Admin;

use App\Leap;
use App\Course;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\LeapResource;
use App\Http\Resources\LeapResourceCollection;

class LeapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_slug)
    {
        $course = Course::findBySlugOrFail($course_slug);

        return view('admin.leap.index', ['course' =>$course]);
    }

    public function apiIndex(Request $request,$course_id) {
        
        $course = Course::find($course_id);

        $searchKeyword = $request->input('searchInput');

        $leap=$course->leap()->search($searchKeyword)->paginate(25);

        return new LeapResourceCollection($leap); 

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_slug)
    {
        $course = Course::findBySlugOrFail($course_slug);


        $leap = new Leap;

        return view('admin.leap.create', ['course' => $course, 'leap'=> $leap]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $leap=Leap::create($request->all());

        return response()->json(['leap' => $leap]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Leap  $leap
     * @return \Illuminate\Http\Response
     */
    public function show(Leap $leap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leap  $leap
     * @return \Illuminate\Http\Response
     */
    public function edit($course_slug,$leap_id)
    {
        $course = Course::findBySlugOrFail($course_slug);
        $leap = Leap::findOrFail($leap_id);
  


        // $this->authorize('update', $file);

        return view('admin.leap.edit', ['course' => $course, 'leap' => $leap]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leap  $leap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $leap = Leap::find($id);

        $leap->update($request->all());

        return response()->json(['leap' => $leap]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leap  $leap
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //\
        $leap = Leap::find($id);
        $leap->delete();
        return \response()->json(['leap'=>$leap]);

    }
}
