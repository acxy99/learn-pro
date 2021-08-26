<?php

namespace App\Http\Controllers\Admin;

use App\Pla;
use App\Course;
use App\Topic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\PlaResource;
use App\Http\Resources\PlaResourceCollection;

class PlaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_slug,$topic_id)
    {
        $course = Course::findBySlugOrFail($course_slug);

        $topic = Topic::find($topic_id);

        return view('admin.pla.index', ['course' =>$course,'topic'=>$topic]);
    }
    

    public function apiIndex(Request $request,$topic_id) {
        
        $topic = Topic::find($topic_id);

        
        $searchKeyword = $request->input('searchInput');

        $pla=$topic->pla()->search($searchKeyword)->paginate(25);

        return new PlaResourceCollection($pla); 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_slug,$topic_id)
    {
        $course = Course::findBySlugOrFail($course_slug);

        $topic= Topic::find($topic_id);

        $pla = new Pla;

        return view('admin.pla.create', ['course' => $course, 'pla'=> $pla, 'topic'=>$topic]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pla=Pla::create($request->all());


       
        return response()->json(['pla' => $pla]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pla  $pla
     * @return \Illuminate\Http\Response
     */
    public function show(Pla $pla)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pla  $pla
     * @return \Illuminate\Http\Response
     */
    public function edit($course_slug,$topic_id,$pla_id)
    {
        $course = Course::findBySlugOrFail($course_slug);
        $pla = Pla::findOrFail($pla_id);
        $topic = Topic::findOrFail($topic_id);
        
        // $this->authorize('update', $file);

        return view('admin.pla.edit', ['course' => $course, 'pla' => $pla, 'topic'=>$topic]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pla  $pla
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $pla = Pla::find($id);

        $pla->update($request->all());
        
        

        return response()->json(['pla' => $pla]);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pla  $pla
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $pla = Pla::find($id);

        $pla->delete();

        return response()->json(['pla' => $pla]);
    }
}
