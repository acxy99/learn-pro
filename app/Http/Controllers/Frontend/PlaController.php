<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
Use App\Pla;
use App\PlaResult;
use App\Topic;
use App\User;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CourseResourceCollection;
use App\Http\Resources\PageResourceCollection;
use App\Http\Resources\FileResourceCollection;
use App\Http\Resources\PlaResultResource;

class PlaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_slug,$topic_id)
    {
        $topic = Topic::find($topic_id);
        $course = Course::findBySlugOrFail($course_slug);
        
        return view('frontend.mycourse.pla_topic',['topic' => $topic ,'course'=>$course]);
    }

    public function result($id,$topic_id) {
        
        $result = PlaResult::where('learner_id','=',$id)
                            ->where('topic_id','=',$topic_id)->first();
        return new PlaResultResource($result);
    }
    
    
    
    public function show(Request $request,  $topic_id)
    {
        
        $questions= collect();
        $topic =Topic::find($topic_id);
        
        $questions=$topic->pla()->inRandomOrder()->limit($topic->num_ques)->get();

        return response()->json(compact(['questions']));
    }

    public function startPla(Request $request, Topic $topic)
    {
        // $user = $request->user();
        // $topic = Topic::find ($topic_id);

        // $answers = Session::get("topic_pla");
        // $answers = collect($answers);

        // $questionFields = ['id', 'qtype', 'question', 'options' , 'mark',];

        // if ($answers->isEmpty()) {
        //     $plas = $topic->pla->shuffle()->take($topic->num_ques)->map(function($q) use($answers, $questionFields){
        //         $answers->push(['id'=> $q->id]);
        //         return collect($q->toArray())->only($questionFields)->all();
        //     })->values()->all(); //

        //     Session::put("topic_pla", $answers);
        // } else {

        //     $q = $topic->pla;
        //     $questions= collect();

        //     $answers->map(function($qi) use($q, $questions){
        //         $questions->push($q->firstWhere('id', $qi['id']));
        //     });

        //     $questions = $questions->map(function($q) use($questionFields){
        //         return collect($q->toArray())->only($questionFields)->all();
        //     })->values()->all();
        // }

        // return response()->json(compact('topic','questions', 'answers'));
    }

    public function answerPla(Request $request, $id ,$topic_id)
    {        
        $user = $id;
        $topic =Topic::find($id);
        $answers = Session::get("topic_pla");
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
                    Session::put("topic_pla", $answers);
                }
                
            }
        $answers = Session::get("topic_pla");

        return compact('answers');
    }

    public function completePla(Request $request, $id,$topic_id)
    {

        $answers = Session::get("topic_pla");
        $answers = collect($answers);
        $topic= Topic::find($topic_id);

        $obtainMark = $this->obtain_mark($topic);

        $user = $request->user();
        $result = new PlaResult;
        
        $result->learner_id = $id;
        $result->topic_id = $topic->id;
        $result->answers = $answers;
        $result->obtain_mark = $obtainMark;
        $result->is_pass = $topic->pass_mark < $obtainMark;

        if ($result->save()) {
            Session::forget("topic_pla");
        }

        return response()->json(compact('result'));
    }

    private function obtain_mark(Topic $topic)
    {
        $number = 0;
        $answers = Session::get("topic_pla");
        $answers = collect($answers);

        $questions = $topic->questions;

        $answers->each(function($ans) use($questions, &$number) {
            if(!empty($ans['answer'])) {

                $ques = $questions->firstWhere('id', $ans['id']);
                $intersect = array_intersect($ques->answers, $ans['answer'] );

                if (sizeof($intersect) === sizeof($ques->answers)) {
                    // answer is correct
                    $number += floatval($ques->mark);
                }

            }
            
        });

        return $number;
        
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
