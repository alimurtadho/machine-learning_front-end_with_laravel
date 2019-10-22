(function() {

    // Quickie PubSub
    let o = $({});
    $.subscribe = function() { o.on.apply(o, arguments) };
    $.publish = function() { o.trigger.apply(o, arguments) };


    // Async submit a form's input.
    let submitLaravelRequest = function(e) {
        let form = $(this);
        let method = form.find('input[name="_method"]').val() || 'POST';

        $.ajax({
            type: method,
            url: form.prop('action'),
            data: form.serialize(),
            success: function() {
                $.publish('ajax.request.success', form);
            }
        });

        e.preventDefault();
    };


    // Offer flash notification messages.
    // 'data-remote-success-message' => 'Yay. All Done.'
    $.subscribe('ajax.request.success', function(e, form) {
        let message = $(form).data('remote-success-message');

        if (message) {
            $('.flash').html(message).fadeIn(300).delay(2500).fadeOut(300);
        }
    });


    // Handle success callbacks. To trigger Task.foo(), do:
    // 'data-model' => 'Task', 'data-remote-on-success' => 'foo'
    $.subscribe('ajax.request.success', function(e, form) {
        triggerClickCallback.apply(form, [e, $(form).data('remote-on-success')]);
    });


    // Confirm an action before proceeding.
    let confirmAction = function(e) {
        let input = $(this);

        input.prop('disabled', 'disabled');

        // Or, much better, use a dedicated modal.
        if ( ! confirm(input.data('confirm'))) {
            e.preventDefault();
        }

        input.removeAttr('disabled');
    };


    // Trigger the registered callback for a click or form submission.
    let triggerClickCallback = function(e, method) {
        let that = $(this);

        // What's the name of the parent model/scope/object.
        if ( ! (model = that.closest('*[data-model]').data('model'))) {
            return;
        }


        // As long as the object and method exist, trigger it and pass through the form.
        if (typeof window[model] === 'object' && typeof window[model][method] === 'function') {
            window[model][method](that);
        } else {
            console.error('Could not call method ' + method + ' on object ' + model);
        }

        e.preventDefault();
    };

    // Dom bindings.
    let body = $('body');
    body.on('submit', 'form[data-remote]', submitLaravelRequest);
    body.on('click', 'input[data-confirm], button[data-confirm]', confirmAction);
    body.on('click', '*[data-click]', function(e) {
        triggerClickCallback.apply(this, [e, $(this).data('click')]);
    });
})();