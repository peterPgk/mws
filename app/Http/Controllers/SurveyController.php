<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyResults;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Validator;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
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
     * @return Response
     */
    public function create()
    {
        $questions = Question::with('answers')->get();

        return view('survey.show', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSurveyResults $request
     * @return Response
     */
    public function store(StoreSurveyResults $request)
    {
        //Request is validated in StoreSurveyResults FormRequest object
        $validData = $request->validated();
        //take user answers to store in the database
        $answers = collect($validData['questions'])->pluck('answers')->flatten(1);

        //store the results
        //no need to be in try/catch block, because Laravel take care of this
        auth()->user()->answers()->sync($answers);

        //Fetch current user results to make summary
        $userResults = auth()->user()->results();

        return view('survey.result', compact('userResults'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        dd(auth()->user()->answers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
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
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
