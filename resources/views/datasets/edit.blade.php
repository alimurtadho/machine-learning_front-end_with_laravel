@extends('layouts.app')

@section('title')
    {{ $dataset->isNotPublished() ?  'Publish New Dataset' : 'Update Dataset'}}
@endsection

@section('content')
    <div class="bg-inverse text-white text-center py-5">
        <h1 class="display-4">
            {{ $dataset->isNotPublished() ?  'Publish New Dataset' : 'Update Dataset'}}
        </h1>
        @if($dataset->isNotPublished())
            <div>
                <p class="lead">
                    Almost there! Now you need to upload an image and dataset files to publish the dataset.
                </p>
            </div>
        @endif
    </div>
    <div class="container">
        <div class="row mt-3">
            @include('datasets._sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-block">
                        <form id="edit-dataset-form" role="form" method="POST" action="{{ $dataset->path() }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div {{ $dataset->isNotPublished() && !$dataset->hasMedia() ? 'hidden' : '' }} class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label for="name" class="col-md-12 form-control-label">Give it a name</label>

                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name', $dataset->name) }}" required>

                                    @if ($errors->has('name'))
                                        <p class="form-text text-muted text-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div {{ $dataset->isNotPublished() && !$dataset->hasMedia() ? 'hidden' : '' }} class="form-group row{{ $errors->has('overview') ? ' has-danger' : '' }}">
                                <label for="overview" class="col-md-12 form-control-label">Overview</label>

                                <div class="col-md-12">
                                    <input id="overview" type="text" class="form-control" name="overview"
                                           value="{{ old('overview', $dataset->overview) }}" required>

                                    @if ($errors->has('overview'))
                                        <p class="form-text text-muted text-danger">
                                            <strong>{{ $errors->first('overview') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div {{ $dataset->isNotPublished() && !$dataset->hasMedia() ? 'hidden' : '' }} class="form-group row{{ $errors->has('description') ? ' has-danger' : '' }}">
                                <label for="description" class="col-md-12 form-control-label">Description</label>

                                <div class="col-md-12">
                                    <textarea name="description" id="description" class="form-control" data-markdown>{{ old('description', $dataset->description) }}</textarea>

                                    @if ($errors->has('description'))
                                        <p class="form-text text-muted text-danger">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <hr/>

                            <div class="form-group row{{ $errors->has('image') ? ' has-danger' : '' }}">
                                <label for="image" class="col-md-12 form-control-label">Dataset Image</label>
                                <div class="col-md-12">
                                    <input id="image" type="file" class="form-control-file" name="image" accept="image/jpeg, image/png">
                                    @if($dataset->hasMedia())
                                    <div>
                                        <em class="d-block">Current Image</em>
                                        <img src="{{ $dataset->getFirstMediaUrl() }}" style="max-width: 100px;">
                                    </div>
                                    @endif

                                    @if ($errors->has('image'))
                                        <p class="form-text text-muted text-danger">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </form>

                        <hr/>

                        <div class="form-group row">
                            <label class="col-md-12 form-control-label">Dataset Files</label>
                            <div class="col-md-12">
                                <table class="table table-bordered" id="dataset-file-list" data-model="DatasetFiles">
                                    <thead>
                                        <tr>
                                            <th>File</th>
                                            <th>Type</th>
                                            <th>Size</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataset->getMedia('files') as $file)
                                            @include('datasets._file_list_item')
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <form action="{{ $dataset->path() }}/file"
                                                      class="dropzone" id="dataset-files">
                                                    {!! csrf_field() !!}
                                                </form>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="pull-right">
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
                                    @can('delete', $dataset)
                                        <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-dataset-form').submit();">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    @endcan
                                </div>

                                <a href="#" onclick="event.preventDefault();document.getElementById('edit-dataset-form').submit();"
                                   class="btn btn-primary">
                                    {{ $dataset->isPublished() ? 'Update Dataset' : 'Publish Dataset' }}
                                </a>
                            </div>
                        </div>
                        <form hidden id="delete-dataset-form" action="{{ $dataset->path() }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts._dropzone')
@include('layouts._markdown_editor')

@push('scripts')
<script type="text/javascript">
    window.DatasetFiles = {};

    window.DatasetFiles.changeButton = function(button) {
        button.attr('disabled', 'true');
        button.find('i').addClass('fa-spin');
        button.closest('form').submit();
    };

    window.DatasetFiles.remove = function(form) {
        form.parents('tr').remove();
    };
</script>
@endpush