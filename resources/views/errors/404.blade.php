@extends('layouts.app')

@section('title')
    Not Found
@endsection

@section('content')
    <div class="row text-center">
        <div class="col bg-inverse text-white py-5">
            <h1 class="display-4 align-self-center">
                <i class="fa fa-exclamation-triangle text-warning"></i> Not Found
            </h1>
            <p class="lead">
                Looks like you are trying to access something that doesn't exist!
            </p>
        </div>
    </div>
@endsection
