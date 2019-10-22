<div class="col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            Search
        </div>
        <form method="GET" action="{{ request()->url() }}" class="card-block">
            @foreach(request()->except('search') as $name => $value)
                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            @endforeach
            <div class="input-group">
                <input name="search" type="text" class="form-control" placeholder="Search for..." value="{{ request('search') }}">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
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
                <a class="nav-link{{ request()->is('codes') && request()->url() == request()->fullUrl() ? ' active' : '' }}"
                   href="/codes?{{ request('search') ? 'search='.request('search') : '' }}"><i class="fa fa-fw fa-code"></i> All Codes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ request('trending') ? ' active' : '' }}"
                   href="/codes?trending=1{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-fw fa-fire text-danger"></i> Popular This Week</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ request('popular') ? ' active' : '' }}"
                   href="/codes?popular=1{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-fw fa-magic text-warning"></i> Popular All Time</a>
            </li>

            @if(auth()->check())
                <li class="nav-item">
                    <a class="nav-link{{ request('author') ? ' active' : '' }}"
                       href="/codes?author={{ auth()->user()->username }}{{ request('search') ? '&search='.request('search') : '' }}"><i class="fa fa-fw fa-lightbulb-o text-info"></i> My Codes</a>
                </li>
            @endif
        </ul>
    </div>
</div>
