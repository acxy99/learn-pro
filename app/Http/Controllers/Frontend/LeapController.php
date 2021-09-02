<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
Use App\Leap;
use App\LeapResult;
use App\User;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class LeapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index($course_slug,$topic_id)
    // {
    //     $topic = Topic::find($topic_id);
    //     $course = Course::findBySlugOrFail($course_slug);
        
    //     return view('frontend.mycourse.pla_topic',['topic' => $topic ,'course'=>$course]);
    // }


    
    
    
    public function show(Request $request,  $course_slug)
    {
        
        $questions= collect();
        $course = Course::findBySlugOrFail($course_slug);
        
        $questions=$course->leap()->inRandomOrder()->where('status','=','active')->limit($course->num_ques_ans)->get();

        return response()->json(compact(['questions']));
    }

    public function answerLeap(Request $request, $id ,$course_slug)
    {        
        $user = $id;
        $course = Course::findBySlugOrFail($course_slug);
        $answers = Session::get("course_leap");
        $answers = collect($answers);

            if(sizeof($request->keys()) === 1) {
                $key = $request->keys()[0];
                $ans = $request->get($key, []);
                if (!empty($ans)) {
                    $answers = $answers->map(function($q) use($ans, $key) {
                        if ($q['id'] === $key) {
                            $q['answer'] = $ans;
                        }
                        return $q;
                    });
                    Session::put("course_leap", $answers);
                }
                
            }
        $answers = Session::get("course_leap");

        return compact('answers');
    }

    public function completeLeap(Request $request, $id,$course_slug)
    {

        $answers = Session::get("course_leap");
        $answers = collect($answers);
        $course = Course::findBySlugOrFail($course_slug);
        $user = $request->user();
 
        $newResult = new LeapResult;
        $newResult->learner_id = $id;
        $newResult->course_id = $course->id;
        $newResult->answers = $answers;
        $newResult->obtain_mark = 0;

            if ($newResult->save()) {
                Session::forget("topic_pla");
            }

        return response()->json(compact('result'));
    }

    private function obtain_mark(Topic $topic)
    {
        // $number = 0;
        // $answers = Session::get("topic_pla");
        // $answers = collect($answers);

        // $questions = $topic->pla();

        // $answers->each(function($ans) use($questions, &$number) {
        //     if(!empty($ans['answer'])) {

        //         $ques = $questions->firstWhere('id', $ans['id']);
        //         $intersect = array_intersect($ques->answers, $ans['answer'] );

        //         if (sizeof($intersect) === sizeof($ques->answers)) {
        //             // answer is correct
        //             $number += floatval($ques->mark);
        //         }

        //     }
            
        // });

        // return $number;
        
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
