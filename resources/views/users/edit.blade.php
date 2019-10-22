@extends('layouts.app')

@section('title')
    Update Profile
@endsection

@section('content')
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header">
                        Settings
                    </div>
                    <ul class="nav stacked-tabs flex-column" role="tablist">
                        @foreach (Aimed::settingsTabs()->displayable() as $tab)
                            <li class="nav-item">
                                <a class="nav-link {!! $tab->key === $activeTab ? ' active' : '' !!}" href="#{{ $tab->key }}" data-toggle="tab" role="tab">
                                    <i class="fa fa-btn fa-fw {{ $tab->icon }}"></i>&nbsp;{{ $tab->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    @foreach (Aimed::settingsTabs()->displayable() as $tab)
                        <div role="tabpanel" class="tab-pane{{ $tab->key == $activeTab ? ' active' : '' }}" id="{{ $tab->key }}" aria-controls="{{ $tab->key }}">
                            @include($tab->view)
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
