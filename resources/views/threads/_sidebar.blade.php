<div class="col-md-3">
    @if(auth()->check())
    <div class="mb-3">
        <a class="btn btn-block btn-lg btn-primary" href="/discuss/create">New Discussion</a>
    </div>
    @endif
    <div class="card mb-3">
        <div class="card-header">
            Search
        </div>
        <form method="GET" action="{{ request()->is('t/*') && !request()->is('t/*/*') ? request()->url() : '/discuss' }}" class="card-block">
            @foreach(request()->except('search') as $name => $value)
                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            @endforeach
            <div class="input-group">
                <input name="search" type="text" class="form-control" placeholder="Search for..." value="{{ request('search') }}">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit"><i class="fa fa-fw fa-search"></i></button>
                </span>
            </div>
        </form>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            Filter
        </div>
        <ul class="nav stacked-tabs flex-column">
            <li class="nav-item">
                <a class="nav-link{{ !request()->is('t/*/*') && request()->url() == request()->fullUrl() ? ' active' : '' }}"
                   href="{{ request()->is('t/*') && !request()->is('t/*/*') ? request()->url() : '/discuss' }}"><i class="fa fa-fw fa-globe text-info"></i> All Threads</a>
            </li>
            @if(auth()->check())
                <li class="nav-item">
                    <a class="nav-link{{ request('author') ? ' active' : '' }}"
                       href="{{ request()->is('t/*') && !request()->is('t/*/*') ? request()->url() : '/discuss' }}?author={{ auth()->user()->username }}{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-fw fa-lightbulb-o text-info"></i> My Threads</a>
                </li>
            <li class="nav-item">
                <a class="nav-link{{ request('contributor') ? ' active' : '' }}"
                   href="{{ request()->is('t/*') && !request()->is('t/*/*') ? request()->url() : '/discuss' }}?contributor={{ auth()->user()->username }}{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-fw fa-code-fork text-info"></i> My Participation</a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link{{ request('trending') ? ' active' : '' }}"
                   href="{{ request()->is('t/*') && !request()->is('t/*/*') ? request()->url() : '/discuss' }}?trending=1{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-fw fa-fire text-danger"></i> Popular This Week</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ request('popular') ? ' active' : '' }}"
                   href="{{ request()->is('t/*') && !request()->is('t/*/*') ? request()->url() : '/discuss' }}?popular=1{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-fw fa-magic text-warning"></i> Popular All Time</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ request('answered') == 'true' ? ' active' : '' }}"
                   href="{{ request()->is('t/*') && !request()->is('t/*/*') ? request()->url() : '/discuss' }}?answered=true{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-fw fa-thumbs-o-up text-success"></i> Answered Threads</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ request('answered') == 'false' ? ' active' : '' }}"
                   href="{{ request()->is('t/*') && !request()->is('t/*/*') ? request()->url() : '/discuss' }}?answered=false{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-fw fa-frown-o text-danger"></i> Unanswered Threads</a>
            </li>
        </ul>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            Categories
        </div>
        <ul class="nav stacked-tabs flex-column">
            <li class="nav-item">
                <a class="nav-link{{ request()->is('discuss') ? ' active' : '' }}"
                   href="/discuss?{{ request()->getQueryString() }}"><i class="fa fa-fw fa-circle-o{{ request()->is('discuss') ? ' text-success' : ' text-muted' }}"></i> All Categories</a>
            </li>
            @foreach($categories as $category)
            <li class="nav-item">
                <a class="nav-link{{ request()->is('t/'.$category->slug) ? ' active' : '' }}"
                   href="/t/{{ $category->slug }}?{{ request()->getQueryString() }}"><i class="fa fa-fw fa-circle-o{{ request()->is('t/'.$category->slug) ? ' text-success' : ' text-muted' }}"></i> {{ $category->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
