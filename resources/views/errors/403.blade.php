@extends('layouts.app')

@section('title')
    Unauthorized
@endsection

@section('content')
    <div class="row text-center">
        <div class="col bg-inverse text-white py-5">
            <h1 class="display-4 align-self-center">
                <i class="fa fa-exclamation-triangle text-danger"></i> Unauthorized
            </h1>
            <p class="lead">
                You are unauthorized to access this page! <br />
                @if(!auth()->check())
                    Please <a href="{{ route('login') }}">login</a> and try again.
                @endif
            </p>
        </div>
    </div>
@endsection
