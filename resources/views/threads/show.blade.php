@extends('layouts.app')

@section('title')
    {{ $thread->name }}
@endsection
@section('content')
    <div class="container">
        <div class="row mt-3">
            @include('threads._sidebar')
            <div class="col-md-9">
                <div class="card mb-3">
                    <div class="card-block">
                        @can('update', $thread)
                        <div class="pull-right">
                            <a href="{{ $thread->path() }}/edit" class="btn btn-primary">Edit Thread</a>
                        </div>
                        @endcan
                        <h1 class="display-4">{{ $thread->name }}</h1>
                        <small class="text-muted">
                            Published in <a href="{{ $thread->category->path() }}">{{ $thread->category->name }}</a> {{ $thread->created_at->diffForHumans() }} by
                            <a class="btn px-0" href="{{ $thread->creator->path() }}">
                                <img class="rounded-circle" src="{{ $thread->creator->gravatar }}" style="max-height: 25px;">
                                {{ $thread->creator->name }}
                            </a>
                        </small>

                        <hr />

                        <div class="user-content">
                            {!! $thread->body_html !!}
                        </div>

                        @if($thread->isAnswered() && $best_reply)
                        <div class="card">
                            <div class="card-header card-success text-white">
                                Best Reply
                            </div>
                            <div class="card-content">
                                @include('threads.reply', ['reply' => $best_reply, 'embeded' => true])
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div id="thread-replies">
                    @foreach($replies as $reply)
                        @include('threads.reply', [
                            'thread' => $thread,
                            'reply' => $reply,
                        ])
                    @endforeach
                </div>

                {{ $replies->fragment('thread-replies')->links() }}

                @if (auth()->check())
                    <div id="accordion" role="tablist">
                        <div class="card mt-3">
                            <div class="card-header" role="tab" id="leave-reply">
                                <a data-toggle="collapse" data-parent="#accordion" href="#reply-form" aria-controls="reply-form">
                                    Leave a Reply
                                </a>
                            </div>
                            <div class="card-block collapse" id="reply-form" role="tabpanel" aria-labelledby="leave-reply">
                                <form method="POST" action="{{ $thread->path() . '/replies' }}">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <textarea name="body" id="body" class="form-control" data-markdown placeholder="Have something to say?"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-default">Reply</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center my-2">
                        Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection

@include('layouts._markdown_editor')