@extends('layouts.app')

@section('content')

    {{ $errors }}

    <div class="container">
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
{{--                        {{ 'questions.question_'. $loop->iteration .'.answers' }}--}}
                    {{ $errors->first('questions.question_'. $loop->iteration .'.answers') }}
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('questions.question_'. $loop->iteration .'.answers') }}</strong>
                        </span>
                        @enderror

                        <ul>
                            @foreach($question->answers as $answer)

                                <label class="check">
                                    <input type="hidden" value="{{ $question->id }}" name="questions[question_{{ $question->id }}][id]">
                                    <input type="checkbox"
                                           name="questions[question_{{ $question->id }}][answers][]"
                                           id="{{ $question->id }}_{{ $answer->id }}"
                                           value="{{ $answer->id }}"
                                    >
                                    {{ $answer->text }}
                                    <span class="checkbox"></span>
                                </label>

                            @endforeach
                        </ul>

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