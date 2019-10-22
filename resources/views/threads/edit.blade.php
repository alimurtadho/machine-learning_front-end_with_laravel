@extends('layouts.app')

@section('title')
    Update Thread
@endsection

@section('content')
    <div class="bg-inverse text-white text-center py-5">
        <h1 class="display-4">Update Thread</h1>
    </div>
    <div class="container">
        <div class="row mt-3">
            @include('threads._sidebar')
            <div class="col-md-9">
                <div class="card">
                    <form role="form" method="POST" action="{{ $thread->path() }}" class="card-block">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group row{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                            <label for="category_id" class="col-md-12 form-control-label">Select a category</label>

                            <div class="col-md-12">
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Choose One</option>

                                    @foreach ($categoryList as $name => $value)
                                        <option value="{{ $value }}" {{ old('category_id', $thread->category_id) == $value ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('category_id'))
                                    <p class="form-text text-muted text-danger">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-md-12 form-control-label">Give a Name for the Discussion</label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" name="name"
                                       value="{{ old('name', $thread->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                    <p class="form-text text-muted text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('body') ? ' has-danger' : '' }}">
                            <label for="body" class="col-md-12 form-control-label">What do you want to talk about</label>

                            <div class="col-md-12">
                                <textarea name="body" id="body" class="form-control" data-markdown>{{ old('body', $thread->body) }}</textarea>

                                @if ($errors->has('body'))
                                    <p class="form-text text-muted text-danger">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    @can('delete', $thread)
                                        <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-thread-form').submit();">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    @endcan
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Update Discussion
                                </button>
                                <a href="{{ $thread->path() }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <form hidden id="delete-thread-form" action="{{ $thread->path() }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts._markdown_editor')
