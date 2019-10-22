@extends('layouts.app')

@section('title', 'Home')
@section('content')
    <div class="py-5 text-center bg-inverse text-white">
        <div class="container">
            <h1 class="display-4">Welcome to Machine learning prediction</h1>
            <p class="lead">A place for using Data Science in Medicine.</p>

            <!-- <img src="{{URL::asset('/img/avataaars.svg')}}" /> -->

            <!-- <p>
                @if(auth()->check())
                    <a class="btn btn-primary" href="/datasets/publish"><i class="fa fa-database"></i> Publish Dataset</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">Create an Account</a>
                @endif
                <a href="{{ url('/datasets') }}" class="btn btn-secondary">Browse Datasets</a>
            </p> -->
        </div>
    </div>

    <!-- <div class="py-4">
        <div class="container">
            @if(!auth()->check())
            <div class="row text-left">
                <div class="col-md-3 col-sm-6">
                    <h2>Datasets</h2>
                    <p>Explore, Analyze and Share Public Medical Data</p>
                    <p><a class="btn btn-secondary" href="/datasets" role="button">Browse »</a></p>
                </div>

                <div class="col-md-3 col-sm-6">
                    <h2>Code</h2>
                    <p>Publish and find code through the community</p>
                    <p><a class="btn btn-secondary" href="/codes" role="button">Browse »</a></p>
                </div>
                <div class="col-md-3 col-sm-6">
                    <h2>News</h2>
                    <p>Stay up-to-date on news and publications related to Medicine and Artificial Intelligence</p>
                    <p><a class="btn btn-secondary" href="/news" role="button">Browse »</a></p>
                </div>

                <div class="col-md-3 col-sm-6">
                    <h2>Discussions</h2>
                    <p>Discuss about datasets, code and find new ways to help the community through data science</p>
                    <p><a class="btn btn-secondary" href="/discuss" role="button">Browse »</a></p>
                </div>
            </div>
            @endif
            <div class="row justify-content-md-center text-left">
                <div class="col-md-3 col-sm-6">
                    <h2>Heart Disease Prediction</h2>
                    <p>Predict heart disease using our algorithm</p>
                    <p><a class="btn btn-secondary" href="/predict/heart" role="button">Predict »</a></p>
                </div>

                <div class="col-md-3 col-sm-6">
                    <h2>Diabetes Prediction</h2>
                    <p>Predict diabetes using our algorithm</p>
                    <p><a class="btn btn-secondary" href="/predict/diabetes" role="button">Predict »</a></p>
                </div>
            </div>
        </div>
    </div> -->
@endsection