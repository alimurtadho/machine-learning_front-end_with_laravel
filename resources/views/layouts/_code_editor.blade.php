@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ace.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/theme-monokai.js"></script>
<script>
    $(function () {
        $('textarea[data-editor]').each(function () {
            var textarea = $(this);
            var mode = textarea.data('editor');
            var editDiv = $('<div>', {
                position: 'absolute',
                width: textarea.width(),
                height: textarea.height(),
                'class': textarea.attr('class')
            }).insertBefore(textarea);
            textarea.attr('hidden', 'true');
            textarea.after('<p class="help-block"><small>Python language is only supported for now.</small></p>');
            var editor = ace.edit(editDiv[0]);
            editor.getSession().setValue(textarea.val());
            editor.getSession().setMode("ace/mode/" + mode);
            editor.setTheme("ace/theme/monokai");

            textarea.closest('form').submit(function () {
                textarea.val(editor.getSession().getValue());
            })
        });
    });
</script>
@endpush