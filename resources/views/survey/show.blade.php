@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h3>
            @empty($results)
                {{ __("Take a survey") }}
            @else
                {{ __("Edit your survey") }}
            @endempty
        </h3>
    </div>

    <hr>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ route('survey.store') }}" novalidate>
                @csrf
                <div class="form-section">
                    @foreach($questions as $question)
                        <legend class="show-control  @error('questions.question_'. $loop->iteration .'.answers') is-invalid @enderror"  >
                            {{ $question->text }}
                        </legend>

                        @error('questions.question_'. $loop->iteration .'.answers')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('questions.question_'. $loop->iteration .'.answers') }}</strong>
                            </span>
                        @enderror

                        <ul>
                            @foreach($question->answers as $answer)
                                <label class="check">
                                    <input type="hidden" value="{{ $question->id }}" name="questions[question_{{ $question->id }}][id]">
                                    <input type="checkbox"
                                        @empty($results)
                                            @if(is_array(old("questions.question_$question->id.answers")) && in_array($answer->id, old("questions.question_$question->id.answers")))
                                               checked
                                            @endif
                                        @else
                                           {{ in_array($answer->id, $results) ? 'checked' : '' }}
                                        @endempty
                                        name="questions[question_{{ $question->id }}][answers][]"
                                        id="{{ $question->id }}_{{ $answer->id }}"
                                        value="{{ $answer->id }}"
                                    >
                                    {{ $answer->text }}
                                    <span class="checkbox"></span>
                                </label>
                            @endforeach
                        </ul>

                        <hr>
                    @endforeach
                </div>

                <div class="form-group row mb-0">
                   <div class="col-md-6 offset-md-4">
                       <button type="submit" class="btn btn-primary">
                           {{ __('Create') }}
                       </button>
                   </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection