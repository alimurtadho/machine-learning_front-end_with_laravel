<a href="{{ $dataset->path() }}" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex justify-content-left w-100">
        <div class="align-self-center mr-2">
            <div class="vote-button-container d-flex flex-column">
                <div class="vote-button-caret px-2"><span class="fa fa-caret-up"></span></div>
                <div class="vote-button-count px-2"><span>{{ $dataset->votes_count }}</span></div>
            </div>
        </div>
        <div class="d-inline-flex align-self-center w-25">
            <div>
                <img class="img-fluid" src="{{ $dataset->getFirstMediaUrl('default', 'thumb') }}">
            </div>
        </div>
        <div class="align-self-center pl-5 mr-3 w-50">
            <h4>{{ $dataset->name }}</h4>
            <p class="lead">{{ $dataset->overview }}</p>
            <small>By {{ $dataset->creator->name }}</small>
        </div>

        <div class="align-self-center w-25">
            @if($dataset->isNotPublished()) <div class="w-100"><span class="badge badge-warning">Not Published</span></div> @endif
            <small class="w-100">Updated {{ $dataset->updated_at->diffForHumans() }}</small>
        </div>
    </div>
</a>