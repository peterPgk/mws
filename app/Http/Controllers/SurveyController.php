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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        /**
         * Take previous user results if any.
         * If there are results, we will allow user to edit them.
         */
        $results = auth()->user()->results()->pluckMulti('answers.id')->toArray();

        $questions = Question::with('answers')->get();

        return view('survey.show', compact('questions', 'results'));
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
}
