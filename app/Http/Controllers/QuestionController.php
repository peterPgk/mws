<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestion;
use App\Question;
use App\UserAnswer;
use Arr;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
//        dd(UserAnswer::all()->toArray());

        $questions = Question::with('answers')->get();
        return view('questions.list', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQuestion $request
     * @return void
     * @throws Throwable
     */
    public function store(StoreQuestion $request)
    {

        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $question = Question::create([
                'text' => $data['text']
            ]);

            /**
             * INFO: There is createMany method, but it basically make the same
             */
            foreach ($data['answers'] as $answer) {
                $question->answers()->create(['text' => $answer]);
            }
        });

        return redirect()->route('questions.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @return void
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return void
     * @throws Throwable
     */
    public function destroy(Question $question)
    {
        if ( $question->hasAnswered() ) {
            flash()->error('You can not delete question, that already has selected answers.');
            return redirect()->back();
        }

        DB::transaction(function () use ($question) {
            $question->answers()->delete();
            $question->delete();
        });

        return redirect()->back();
    }
}
