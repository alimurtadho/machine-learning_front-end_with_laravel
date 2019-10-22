@extends('layouts.app')

@section('title')
    Publish New Dataset
@endsection

@section('content')
    <div class="bg-inverse text-white text-center py-5">
        <h1 class="display-4">Publish New Dataset</h1>
    </div>
    <div class="container">
        <div class="row mt-3">
            @include('datasets._sidebar')
            <div class="col-md-9">
                <div class="card">
                    <form role="form" method="POST" action="/datasets" class="card-block">
                        {{ csrf_field() }}

                        <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-md-12 form-control-label">Give it a name</label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" name="name" placeholder="{{ trans('dataset.values.name') }}"
                                       value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <p class="form-text text-muted text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('overview') ? ' has-danger' : '' }}">
                            <label for="overview" class="col-md-12 form-control-label">Overview</label>

                            <div class="col-md-12">
                                <input id="overview" type="text" class="form-control" name="overview" placeholder="{{ trans('dataset.values.overview') }}"
                                       value="{{ old('overview') }}" required>

                                @if ($errors->has('overview'))
                                    <p class="form-text text-muted text-danger">
                                        <strong>{{ $errors->first('overview') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('description') ? ' has-danger' : '' }}">
                            <label for="description" class="col-md-12 form-control-label">Description</label>

                            <div class="col-md-12">
                                <textarea name="description" id="description" class="form-control" data-markdown>{{ old('description', trans('dataset.values.description')) }}</textarea>

                                @if ($errors->has('description'))
                                    <p class="form-text text-muted text-danger">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-arrow-right"> </i> Next
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts._markdown_editor')
