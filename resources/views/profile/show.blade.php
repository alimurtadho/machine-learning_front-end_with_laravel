@extends('layouts.app')

@section('title')
    {{ $user->name }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-md-center mt-3">
            <div class="col-lg-3">
                <img class="img-fluid" src="{{ $user->gravatar }}" alt="{{ $user->name }}" style="min-width: 200px;">
            </div>
            <div class="col-lg-9">
                <h1 class="display-3">{{ $user->name }}</h1>
                @if($user->occupation && $user->organization)
                <p class="lead">{{ $user->occupation }} at {{ $user->organization }}</p>
                @endif
                <ul class="list-inline">
                    @if($user->github_username)
                    <li class="list-inline-item">
                        <a class="btn bg-inverse text-white" href="https://github.com/{{ $user->github_username }}" target="_blank">
                            <i class="fa fa-github"></i> Github
                        </a>
                    </li>
                    @endif
                    @if($user->linkedin_username)
                    <li class="list-inline-item">
                        <a class="btn btn-primary" href="https://linkedin.com/in/{{ $user->linkedin_username }}" target="_blank">
                            <i class="fa fa-linkedin"></i> Linkedin
                        </a>
                    </li>
                    @endif
                    @if($user->website)
                    <li class="list-inline-item">
                        <a class="btn btn-secondary" href="{{ url($user->website) }}" target="_blank">
                            <i class="fa fa-globe"></i> Website
                        </a>
                    </li>
                    @endif

                </ul>
            </div>

            <div class="col-lg-12 mt-3" id="user-datasets">
                <div class="card">
                    <div class="card-header">
                        <h3>Datasets ({{ $datasets->total() }})</h3>
                    </div>
                    <div class="list-group list-group-flush">
                        @each('datasets._flex_item', $datasets, 'dataset', 'datasets._empty_flex_item')
                    </div>
                    @if($datasets->hasPages())
                        <div class="card-block">
                            {{ $datasets->fragment('user-datasets')->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-12 mt-3" id="user-codes">
                <div class="card">
                    <div class="card-header">
                        <h3>Codes ({{ $codes->total() }})</h3>
                    </div>
                    <div class="list-group list-group-flush">
                        @each('codes._flex_item', $codes, 'code', 'codes._empty_flex_item')
                    </div>
                    @if($codes->hasPages())
                        <div class="card-block">
                            {{ $codes->fragment('user-codes')->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
