<div class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex justify-content-left w-100">
        <div class="align-self-center">
            <img class="img-responsive rounded-circle" src="{{ $thread->creator->gravatar }}" style="max-height: 35px;">
        </div>
        <div class="align-self-center ml-3">
            <h4><a href="{{ $thread->path() }}" >{{ $thread->name }}</a></h4>
            <p class="lead">
                {{ str_limit(strip_tags($thread->body_html), 140) }}
            </p>

            <ul class="list-inline">
                <li class="list-inline-item">Posted in <a href="{{ $thread->category->path() }}" class="text-danger">{{ $thread->category->name }}</a></li>
                <li class="list-inline-item">&bull; <a href="{{ $thread->path() }}" class="text-muted">{{ $thread->updated_at->diffForHumans() }}</a></li>
                <li class="list-inline-item">&bull; By <a href="{{ $thread->creator->path() }}" class="text-success">{{ $thread->creator->name }}</a></li>
                <li class="list-inline-item hidden-md-down">&bull; {{ $thread->replies_count }} Replies</li>
            </ul>
        </div>
    </div>
</div>