@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('textarea[data-markdown]').each(function () {
            var mde = new SimpleMDE({ autoDownloadFontAwesome: false, element: this });
            $(this).after('<p class="help-block"><small class="text-muted"><a href="http://commonmark.org/help/" target="_blank">CommonMark Markdown</a> is supported.</small></p>');
        });
    });
</script>
@endpush