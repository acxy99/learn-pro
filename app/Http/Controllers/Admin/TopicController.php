<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Topic;
use App\Pla;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreTopic;
use App\Http\Requests\UpdateTopic;

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

        $this->authorize('index', [Topic::class,$course]);

        return view('admin.topic.index', ['course' => $course]);
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
    public function create($course_slug)
    {
        //
        $course = Course::findBySlugOrFail($course_slug);

        // $this->authorize('create', [Topic::class, $course]);
        $topic = new Topic;


        return view('admin.topic.create', ['course' => $course, 'topic'=>$topic]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTopic $request)
    {
        //
        $topic = Topic::create($request->all());

        return response()->json(['topic' => $topic]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show($course_slug,$topic_id) {
        $course = Course::findBySlugOrFail($course_slug);
        $topic = Topic::find($topic_id);

        return view('admin.topic.show', [
            'course' => $course, 
            'topic' => $topic,
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit($course_slug,$topic_id)
    {
        $course = Course::findBySlugOrFail($course_slug);
        $topic = Topic::findOrFail($topic_id);
        // $this->authorize('update', $file);

        return view('admin.topic.edit', ['course' => $course, 'topic' => $topic]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTopic $request,$id)
    {
        //
        $topic = Topic::find($id);

        $topic->update($request->all());

        return response()->json(['topic' => $topic]);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic = Topic::find($id);

        $topic->delete();

        return response()->json(['topic' => $topic]);
    }
}
