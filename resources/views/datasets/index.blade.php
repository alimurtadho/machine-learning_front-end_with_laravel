@extends('layouts.app')

@section('title')
    Datasets
@endsection

@section('content')
    <div class="bg-inverse text-white text-center py-5">
        <h1 class="display-4">Datasets</h1>
    </div>
    <div class="container">
        <div class="row mt-3">
            @include('datasets._sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        {{ $datasets->total() }} {{ str_plural('Dataset', $datasets->total()) }}
                    </div>
                    <div class="list-group list-group-flush">
                        @each('datasets._flex_item', $datasets, 'dataset', 'datasets._empty_flex_item')
                    </div>
                    @if($datasets->hasPages())
                        <div class="card-block">
                            {{ $datasets->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
