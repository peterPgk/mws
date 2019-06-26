<?php

namespace App\Http\Requests;

use App\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSurveyResults extends FormRequest
{

    /**
     * @var Collection|static[]
     */
    private $questions;

    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->questions = Question::with('answers')->get();
    }

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
        return $this->questions->mapWithKeys(function ($question) {
            return [
                'questions.question_'. $question->id => 'required',
                'questions.question_'. $question->id . '.id' => 'exists:questions,id',
                'questions.question_'. $question->id . '.answers' => 'required|array',
                'questions.question_'. $question->id . '.answers.*' => ['distinct', Rule::in($question->answers->pluck('id'))]
            ];
        })->toArray();
    }

    public function messages()
    {
        return [
            'questions.*.answers.required' => 'You need to select at least one answer'
        ];
    }
}
