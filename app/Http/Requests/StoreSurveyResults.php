<?php

namespace App\Http\Requests;

use App\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSurveyResults extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $questions = Question::with('answers')->get();
        return $questions->mapWithKeys(function ($question) {
            return [
                'questions.question_'. $question->id => 'required',
                'questions.question_'. $question->id . '.id' => 'exists:questions,id',
                'questions.question_'. $question->id . '.answers' => 'required|array',
                'questions.question_'. $question->id . '.answers.*' => ['distinct', Rule::in($question->answers->pluck('id'))]
            ];
        })->toArray();
    }
}
