<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * INFO: We can use $this->>method() to change some validation rules depending on
 *      the HTTP method, but prefer this solution, for me is cleaner
 *
 *
 * Class UpdateQuestion
 * @package App\Http\Requests
 */
class UpdateQuestion extends FormRequest
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
        return [
            'text' => ['required','string','min:3',
                Rule::unique('questions', 'text')->ignore($this->route('question') ?? 0)
            ],
            'answers' => 'required|array|min:1',
            'answers.*' => 'string|min:3',
        ];
    }
}
