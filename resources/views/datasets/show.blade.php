@extends('layouts.app')

@section('title')
    {{ $dataset->name }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-md-center mt-3">
            @can('update', $dataset)
                <div class="col-lg-12 align-self-end">
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ $dataset->path() }}/edit">Edit Dataset</a>
                        @can('publish', $dataset)
                            <a class="btn btn-secondary" href="{{ $dataset->path() }}/publish">
                                {{ $dataset->isPublished() ? 'Un-Publish Dataset' : 'Publish Dataset' }}
                            </a>
                        @endcan
                        @can('feature', $dataset)
                            <a class="btn btn-success" href="{{ $dataset->path() }}/feature">
                                <i class="fa fa-star"></i> {{ $dataset->isFeatured() ? 'Un-Feature Dataset' : 'Feature Dataset' }}
                            </a>
                        @endcan
                    </div>
                </div>
            @endcan
            <div class="col-lg-3">
                <img class="img-fluid" src="{{ $dataset->getFirstMediaUrl('default', 'big') }}" alt="{{ $dataset->name }}" style="min-width: 200px;">
            </div>
            <div class="col-lg-9">
                <div class="pull-right">
                    <div class="vote-button-container clickable d-flex flex-column" data-action="{{ $dataset->path() }}/vote">
                        <div class="vote-button-caret px-2"><span class="fa fa-caret-up"></span></div>
                        <div class="vote-button-count px-2"><span>{{ $dataset->votes_count }}</span></div>
                    </div>
                </div>
                <h1 class="display-3">{{ $dataset->name }}</h1>
                <p class="lead">{{ $dataset->overview }}</p>
                <ul class="list-inline">
                    <li class="list-inline-item">
                        By <a href="{{ $dataset->creator->path() }}">{{ $dataset->creator->name }}</a>
                    </li>
                    <li class="list-inline-item">
                        <small class="text-muted">Last updated {{ $dataset->updated_at->diffForHumans() }}</small>
                    </li>
                </ul>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="card">
                    <h3 class="card-header">
                        Description
                    </h3>
                    <div class="card-block user-content">
                        {!! $dataset->description_html !!}
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="card">
                    <h3 class="card-header">
                        Files
                    </h3>
                    <div class="list-group list-group-flush">
                        @forelse($dataset->getMedia('files') as $file)
                            <a class="list-group-item" href="{{ $file->getUrl() }}">{{ $file->file_name }}</a>
                        @empty
                            <a class="list-group-item">No Attached Files</a>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-3" id="dataset-codes">
                <div class="card">
                    <div class="card-header">
                        <a class="pull-right btn btn-primary" href="/c/{{ $dataset->slug }}/publish"><i class="fa fa-code"></i> Publish</a>
                        <h3>Codes ({{ $codes->total() }})</h3>
                    </div>
                    <div class="list-group list-group-flush">
                        @each('codes._flex_item', $codes, 'code', 'codes._empty_flex_item')
                    </div>
                    @if($codes->hasPages())
                    <div class="card-block">
                        {{ $codes->fragment('dataset-codes')->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts._code_highlight')