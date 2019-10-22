<tr>
    <td><a href="{{ $file->getUrl() }}">{{ $file->name }}</a></td>
    <td>{{ $file->mime_type }}</td>
    <td>{{ sizeForHumans($file->size) }}</td>
    <td>
        <form data-remote data-remote-on-success="remove" method="POST" action="{{ $dataset->path() }}/{{ $file->id }}">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}
            <button data-click="changeButton" class="btn btn-danger btn-sm">
                <i class="fa fa-trash-o"></i> Delete
            </button>
        </form>
    </td>
</tr>