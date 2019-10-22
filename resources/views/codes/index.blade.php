@extends('layouts.app')

@section('title')
    Codes
@endsection

@section('content')
    <div class="bg-inverse text-white text-center py-5">
        <h1 class="display-4">Codes</h1>
    </div>
    <div class="container">
        <div class="row mt-3">
            @include('codes._sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        {{ $codes->total() }} {{ str_plural('Code', $codes->total()) }}
                    </div>
                    <div class="list-group list-group-flush">
                        @each('codes._flex_item', $codes, 'code', 'codes._empty_flex_item')
                    </div>
                    @if($codes->hasPages())
                        <div class="card-block">
                            {{ $codes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
