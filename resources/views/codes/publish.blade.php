@extends('layouts.app')

@section('title')
    Publish Code for {{ $dataset->name }}
@endsection

@section('content')
    <div class="bg-inverse text-white text-center py-5">
        <h1 class="display-4">Publish Code for </h1>
        <p class="lead"><a href="{{ $dataset->path() }}" class="text-white">{{ $dataset->name }}</a> by <a href="{{ $dataset->creator->path() }}" class="text-white">{{ $dataset->creator->name }}</a></p>
    </div>
    <div class="container">
        <div class="row mt-3">
            @include('codes._sidebar')
            <div class="col-md-9">
                <div class="card">
                    <form role="form" method="POST" action="/codes" class="card-block">
                        {{ csrf_field() }}

                        <input type="hidden" name="dataset_id" value="{{ $dataset->id }}">

                        <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-md-12 form-control-label">Name</label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" name="name"
                                       value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <p class="form-text text-muted text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('description') ? ' has-danger' : '' }}">
                            <label for="description" class="col-md-12 form-control-label">Description</label>

                            <div class="col-md-12">
                                <textarea name="description" id="description" class="form-control" data-markdown>{{ old('description') }}</textarea>

                                @if ($errors->has('description'))
                                    <p class="form-text text-muted text-danger">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('code') ? ' has-danger' : '' }}">
                            <label for="code" class="col-md-12 form-control-label">Code</label>

                            <div class="col-md-12">
                                <textarea name="code" id="code" class="form-control" data-editor="python" rows="20">{{ old('code') }}</textarea>

                                @if ($errors->has('code'))
                                    <p class="form-text text-muted text-danger">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('publish') ? ' has-danger' : '' }}">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="1" name="publish" {{ old('publish') ? 'checked' : '' }}> Publish Code
                                    </label>
                                </div>

                                @if ($errors->has('publish'))
                                    <p class="form-text text-muted text-danger">
                                        <strong>{{ $errors->first('publish') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"> </i> Save
                                </button>
                                <a href="{{ $dataset->path() }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts._code_editor')
@include('layouts._markdown_editor')
