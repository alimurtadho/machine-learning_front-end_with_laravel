<?php $thread = $thread ?? $reply->thread; ?>
<div class="card py-2">
    <div class="card-block">
        <div class="media">
            <div class="d-flex flex-column align-items-center mr-3">
                <img class="mb-1" src="{{ $reply->creator->gravatar }}" alt="{{ $reply->creator->name }}">
                @if(!($embeded ?? false))
                    <div>
                        @can('select-best-answer', $reply)
                            @if($thread->isNotAnswered())
                            <div class="d-inline-block">
                                <form method="POST" action="{{ $reply->path() }}">
                                    {!! csrf_field() !!}

                                    <button type="submit" class="btn btn-sm btn-success text-white" title="Did this answer your question?">
                                        <i class="fa fa-fw fa-thumbs-up"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        @endcan
                        @can('update', $reply)
                            <a href="{{ $reply->path() }}/edit" class="btn btn-sm btn-secondary d-inline-block">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>
                        @endcan
                    </div>
                @endif
            </div>
            <div class="media-body">
                <h5 class="mt-0">
                    {{ $reply->creator->name }}
                    <small class="text-muted">
                        {{ $reply->created_at->diffForHumans() }}
                    </small>

                    @if(!($embeded ?? false))
                    @if($reply->isBestAnswer())
                        <span class="badge badge-success">Best Answer</span>
                    @endif
                    @endif
                </h5>
                <div class="user-content">
                    {!! $reply->body_html !!}
                </div>
            </div>
        </div>
    </div>
</div>