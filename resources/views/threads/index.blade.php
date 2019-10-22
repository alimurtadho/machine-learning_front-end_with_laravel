@extends('layouts.app')

@section('title')
    Discussion
@endsection

@section('content')
    <div class="bg-inverse text-white text-center py-5">
        <h1 class="display-4">Discussions</h1>
    </div>
    <div class="container">
        <div class="row mt-3">
            @include('threads._sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        {{ $threads->total() }} {{ str_plural('Thread', $threads->total()) }}
                    </div>
                    <div class="list-group list-group-flush">
                        @each('threads._flex_item', $threads, 'thread', 'threads._empty_flex_item')
                    </div>
                    @if($threads->hasPages())
                        <div class="card-block">
                            {{ $threads->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
