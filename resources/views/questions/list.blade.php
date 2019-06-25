@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center mb-2">

            <div class="col-md-10">
                <a class="btn btn-primary float-right" href="{{ route('questions.create') }}">New question</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <ul class="list-group">
                    @foreach($questions as $question)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-9">
                                    <div>
                                        {{ $question->text }}
                                        {{ $question->created_at->format('Y-m-d') }}
                                    </div>
                                    <div>

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <form method="POST" action="{{ route('questions.destroy', ['$question' => $question]) }}" novalidate>
                                        @method('DELETE')
                                        @csrf

                                        <button class="btn btn-primary float-right mr-2">Delete</button>
                                    </form>
                                    <a class="btn btn-primary float-right mr-2" href="{{ route('questions.edit', ['$question' => $question]) }}">Edit</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@endsection