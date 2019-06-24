<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        $questions = Question::with('answers')->get();
//
//        return view('survey.show', compact('questions'));
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = Question::with('answers')->get();

        return view('survey.show', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $answers = collect($request->questions)->pluck('answers')->flatten(1);
//        dd(collect($request->questions)->pluck('answers')->flatten(1));
//        $questions = Question::all();
//
//        $t =  [
//            'questions' => [
//                'id' => 2,
//                'answers' => [
//
//                ]
//            ]
//        ];
//
        dd($request->all());
//
//
//        $request->validate([
//            'questions' => 'required|array',
//            'questions.*.id' => 'exists:questions,id'
//        ]);

        auth()->user()->answers()->sync($answers);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
