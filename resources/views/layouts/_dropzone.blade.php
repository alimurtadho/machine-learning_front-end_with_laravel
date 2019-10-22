@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
<script type="text/javascript">
    Dropzone.options.datasetFiles = {
        success: function(file) {
            $('#dataset-file-list').find('tbody').append(file.xhr.response);
        }
    };
</script>
@endpush