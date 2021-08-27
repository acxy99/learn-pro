<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\User;
use App\Topic;
use App\Course;

use App\Http\Resources\TopicResource;
use App\Http\Resources\TopicResourceCollection;
class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_slug)
    {
        $course = Course::findBySlugOrFail($course_slug);

        return view('frontend.mycourse.topic',['course'=>$course]);
    }

    public function apiIndex(Request $request,$course_id) {
        
        $course = Course::find($course_id);

        $searchKeyword = $request->input('searchInput');

        $topic=$course->topic()->search($searchKeyword)->paginate(25);

        return new TopicResourceCollection($topic); 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($course_slug,$topic_id)
    {
        $course = Course::findBySlugOrFail($course_slug);
        $topic = Topic::find($topic_id);
        return view('frontend.mycourse.topic_view',['course'=>$course,'topic'=>$topic]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
