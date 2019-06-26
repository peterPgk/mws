<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestion;
use App\Http\Requests\UpdateQuestion;
use App\Http\Requests\UpdateUser;
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
        /*
         * INFO: Here we should maybe again check for answers, already answered,
         * because if we allow edit, this can change context and meaning of the answer.
         */

        $question->load('answers');
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateQuestion $request
     * @param Question $question
     * @return void
     */
    public function update(UpdateQuestion $request, Question $question)
    {
        $data = $request->validated();

        DB::transaction(function () use ($question, $data) {
            $question->update([
                'text' => $data['text']
            ]);

            /**
             * INFO: We can try to get this question answers and compare to the new one
             *      to be able to only delete these, that are not in the new array, insert
             *      some new records and update existing.
             *      Something similar to `sync` method for BelongsTo Relation
             */
            $question->answers()->delete();

            foreach ($data['answers'] as $answer) {
                $question->answers()->create([
                    'text' => $answer
                ]);
            }
        });

        return redirect()->route('questions.index');
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
