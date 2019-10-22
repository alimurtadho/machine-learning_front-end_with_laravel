@extends('layouts.app')

@section('title')
    Update Reply
@endsection

@section('content')
    <div class="bg-inverse text-white text-center py-5">
        <h1 class="display-4">Update Reply</h1>
    </div>
    <div class="container">
        <div class="row mt-3">
            @include('threads._sidebar')
            <div class="col-md-9">
                <div class="card">
                    <form role="form" method="POST" action="{{ $reply->path() }}" class="card-block">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group row{{ $errors->has('body') ? ' has-danger' : '' }}">
                            <label for="body" class="col-md-12 form-control-label">Your Reply</label>

                            <div class="col-md-12">
                                <textarea name="body" id="body" class="form-control" data-markdown>{{ old('body', $reply->body) }}</textarea>

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
                                    @can('delete', $reply)
                                        <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-reply-form').submit();">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    @endcan
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Update Reply
                                </button>
                                <a href="{{ $thread->path() }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <form hidden id="delete-reply-form" action="{{ $reply->path() }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts._markdown_editor')
