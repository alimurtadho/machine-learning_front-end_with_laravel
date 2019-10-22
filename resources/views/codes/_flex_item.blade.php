<a href="{{ $code->path() }}" class="list-group-item list-group-item-action flex-column align-items-start pb-4">
    <div class="d-flex justify-content-left w-100">
        <div class="align-self-center mr-2">
            <div class="vote-button-container d-flex flex-column">
                <div class="vote-button-caret px-2"><span class="fa fa-caret-up"></span></div>
                <div class="vote-button-count px-2"><span>{{ $code->votes_count }}</span></div>
            </div>
        </div>
        <div class="d-flex flex-row">
            <div class="align-self-center">
                <div>
                    <img class="img-fluid" src="{{ $code->dataset->getFirstMediaUrl('default', 'thumb') }}">
                </div>
            </div>
            <div class="align-self-end h-25 hidden-md-down">
                <img class="rounded-circle" src="{{ $code->creator->gravatar }}" style="width: 50px; height: 50px; margin-left: -25px;">
            </div>
        </div>
        <div class="align-self-center pl-5 w-50">
            <h4>{{ $code->name }}</h4>
            <p class="small">Using Dataset: <span class="text-primary">{{ $code->dataset->name }}</span></p>
            <small>By {{ $code->creator->name }}</small>
        </div>

        <div class="align-self-center w-25">
            @if(!$code->isPublished()) <div class="w-100"><span class="badge badge-warning">Not Published</span></div> @endif
            <small class="w-100">Updated {{ $code->updated_at->diffForHumans() }}</small>
        </div>
    </div>
</a>