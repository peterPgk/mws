@extends('layouts.app')

{{--<style>--}}
    {{--.form-section ul {--}}
        {{--padding-left: 5px;--}}
        {{--list-style-type: none;--}}
    {{--}--}}
    {{--.form-section legend {--}}
        {{--line-height: 1.2em;--}}
        {{--font-size: 1.3rem;--}}
    {{--}--}}
    {{--.check {--}}
        {{--display: block;--}}
        {{--position: relative;--}}
        {{--padding-left: 25px;--}}
        {{---webkit-user-select: none;--}}
        {{---moz-user-select: none;--}}
        {{---ms-user-select: none;--}}
        {{--user-select: none;--}}
    {{--}--}}

    {{--.check input {--}}
        {{--position: absolute;--}}
        {{--opacity: 0;--}}
        {{--cursor: pointer;--}}
    {{--}--}}

    {{--.checkbox {--}}
        {{--position: absolute;--}}
        {{--top: 3px;--}}
        {{--left: 0;--}}
        {{--width: 16px;--}}
        {{--height: 16px;--}}
        {{--border: 2px solid #2176bd;--}}
        {{--border-radius: 15%;--}}
        {{--cursor: pointer;--}}
    {{--}--}}

    {{--.checkbox:after {--}}
        {{--content: "";--}}
        {{--position: absolute;--}}
        {{--display: none;--}}
        {{--top: 0;--}}
        {{--left: 4px;--}}
        {{--width: 5px;--}}
        {{--height: 10px;--}}
        {{--border: solid white;--}}
        {{--border-width: 0 2px 2px 0;--}}
        {{---webkit-transform: rotate(45deg);--}}
        {{---ms-transform: rotate(45deg);--}}
        {{--transform: rotate(45deg);--}}
        {{--transform-origin: 50% 50%;--}}
        {{--transition: all 0.2s ease;--}}
    {{--}--}}

    {{--.check input:checked ~ .checkbox {--}}
        {{--/*background-color: #e16fa1;*/--}}
        {{--background-color: #2176bd;--}}
    {{--}--}}

    {{--.check input:checked ~ .checkbox:after {--}}
        {{--display: block;--}}
    {{--}--}}
{{--</style>--}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{--<form method="POST" action="{{ route('survey.store') }}" novalidate>--}}
                    {{--@csrf--}}
                <h2>{{__('Your submission')}}</h2>
                <div class="form-section">
                    @foreach($userResults as $question)
                        <legend>{{ $question->text }}</legend>

                        <ul>
                            @foreach($question->answers as $answer)

                                <label class="check">
                                    {{--<input type="hidden" value="{{ $question->id }}" name="questions[question_{{ $question->id }}][id]">--}}
                                    {{--<input type="checkbox"--}}
                                           {{--name="questions[question_{{ $question->id }}][answers][]"--}}
{{--                                           id="{{ $question->id }}_{{ $answer->id }}"--}}
                                           {{--value="{{ $answer->id }}"--}}
                                    {{-->--}}
                                    - {{ $answer->text }}
                                    {{--<span class="checkbox"></span>--}}
                                </label>

                            @endforeach
                        </ul>

                    @endforeach
                </div>

                    {{--<div class="form-group row mb-0">--}}
                        {{--<div class="col-md-6 offset-md-4">--}}
                            {{--<button type="submit" class="btn btn-primary">--}}
                                {{--{{ __('Create') }}--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                {{--</form>--}}

            </div>
        </div>
    </div>
@endsection