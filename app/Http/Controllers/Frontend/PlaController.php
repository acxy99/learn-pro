<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
use App\Page;
use App\File;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CourseResourceCollection;
use App\Http\Resources\PageResourceCollection;
use App\Http\Resources\FileResourceCollection;

class PlaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show()
    {
        

            return view('frontend.mycourse.pla_topic');
        
    }

    public function apiShow($id)
    {
        $user = $request->user();
        $questions= collect();
        $time = Session::get("exam.$exam->id");
        $exam->load('topics', 'subjects');
        $result = $exam->results()->where('examinee', $user->id)->orderBy('created_at', "DESC")->first();

        if ($result && !empty($exam->meta['show_answer']) &&  $exam->meta['show_answer']) {
            $q = $exam->questions;
            
            
            collect($result->answers)->map(function($qi) use($q, $questions){
                $questions->push($q->firstWhere('id', $qi['id']));
            });

            // $questions = $questions->map(function($q) use($questionFields){
            //     return collect($q->toArray())->only($questionFields)->all();
            // })->values()->all();

            if (!(!empty($exam->meta['show_answer']) &&  $exam->meta['show_answer'])) {
                $questions = $questions->map(function($ques) {
                    unset($ques->answers);
                    return $ques;
                });
            }

            return response()->json(compact(['exam', 'time', 'result',  'questions']));
        }
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
