@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Edit question') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('questions.update', ['question' => $question]) }}" novalidate>
                            @method('PUT')
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Question') }}</label>

                                <div class="col-md-8">
                                    <input id="name"
                                           type="text"
                                           class="form-control @error('text') is-invalid @enderror"
                                           name="text"
                                           value="{{ old('text', $question->text) }}"
                                           required
                                           autocomplete="text"
                                           autofocus
                                    >

                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="jumbotron jumbotron-fluid">

{{--                                @foreach($question->answers as $key => $answer)--}}
{{--                                    <div class="col-md-8">--}}
{{--                                        <div class="input-group">--}}
{{--                                            <input id="name"--}}
{{--                                                   type="text"--}}
{{--                                                   class="form-control @error('answers.*') is-invalid @enderror"--}}
{{--                                                   name="answers[]"--}}
{{--                                                   value="{{ old('answers.'. $key, $answer->text) }}"--}}
{{--                                                   required--}}
{{--                                                   autocomplete="text"--}}
{{--                                                   autofocus--}}
{{--                                            >--}}
{{--                                            <div class="btn-group" role="group" aria-label="Second group">--}}
{{--                                                <button type="button" class="btn btn-secondary" v-cloneya-add>--}}
{{--                                                    <span class="fa fa-plus font-weight-bold">&#43;</span>--}}
{{--                                                </button>--}}
{{--                                                <button type="button" class="btn btn-secondary" v-cloneya-remove>--}}
{{--                                                    <span class="fa fa-minus font-weight-bold">&#8722;</span>--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}

{{--                                                                                        --}}
{{--     There is a problem, when have error , the newly created inputs are dissapired      --}}
{{--     This need little more work, but is kind a solution :)                              --}}
{{--                                                                                        --}}



{{--                                @if ($errors->any())--}}
{{--                                    @foreach ($errors->all() as $key => $error)--}}
{{--                                        @if(\Str::contains($error, 'answers'))--}}
{{--                                            @include('questions.vueclonea', ['oldData' => old('answers.'. ($key-1)), 'err' => $error])--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                @else--}}
{{--                                    <vue-cloneya :maximum="5" >--}}
{{--                                        <div class="form-group row" v-cloneya-input>--}}
{{--                                            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Answer') }}</label>--}}
{{----}}
{{--                                            <div class="col-md-8">--}}
{{--                                                <div class="input-group">--}}
{{--                                                    <input id="name"--}}
{{--                                                           type="text"--}}
{{--                                                           class="form-control @error('answers.*') is-invalid @enderror"--}}
{{--                                                           name="answers[]"--}}
{{--                                                           value="{{ old('answers.0') }}"--}}
{{--                                                           required--}}
{{--                                                           autocomplete="text"--}}
{{--                                                           autofocus--}}
{{--                                                    >--}}
{{--                                                    <div class="btn-group" role="group" aria-label="Second group">--}}
{{--                                                        <button type="button" class="btn btn-secondary" v-cloneya-add>--}}
{{--                                                            <span class="fa fa-plus font-weight-bold">&#43;</span>--}}
{{--                                                        </button>--}}
{{--                                                        <button type="button" class="btn btn-secondary" v-cloneya-remove>--}}
{{--                                                            <span class="fa fa-minus font-weight-bold">&#8722;</span>--}}
{{--                                                        </button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </vue-cloneya>--}}
{{--                                @endif--}}


                                @error('answers.*')
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                @if(\Str::contains($error, 'answers'))
                                                    <li>{{ $error }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @enderror

                                @foreach($question->answers as $key => $answer)

                                <vue-cloneya :maximum="5" >
                                        <div class="form-group row" v-cloneya-input>
                                            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Answer') }}</label>

                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <input id="name"
                                                           type="text"
                                                           class="form-control @error('answers.*') is-invalid @enderror"
                                                           name="answers[]"
                                                           value="{{ old('answers.'. $key, $answer->text) }}"
                                                           required
                                                           autocomplete="text"
                                                           autofocus
                                                    >
                                                    <div class="btn-group" role="group" aria-label="Second group">
                                                        <button type="button" class="btn btn-secondary" v-cloneya-add>
                                                            <span class="fa fa-plus font-weight-bold">&#43;</span>
                                                        </button>
                                                        <button type="button" class="btn btn-secondary" v-cloneya-remove>
                                                            <span class="fa fa-minus font-weight-bold">&#8722;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </vue-cloneya>

                                @endforeach

                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Edit') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection