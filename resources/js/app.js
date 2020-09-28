window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');
require('bootstrap');
require('select2');

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.alert:not(.alert-important)').delay(5 * 1000).fadeOut(350);

$('body')
    .on('click', 'form :submit', function() {
        const $input = $(this);
        $input.parents('form').find(':submit').data('clicked', false);
        $input.data('clicked', true)
    })
    .on('submit', 'form', function () {
        const $input = $(':submit', this)
            .prop('disabled', true)
            .filter(function() {
                return $(this).data('clicked') === true
            })
            .first();
        if ($input.attr('name')) {
            $input.parents('form')
                .append(
                    $('<input type="hidden">')
                        .attr('name', $input.attr('name'))
                        .val($input.val())
                )
        }
        const $icon = $input.find('i');
        if ($icon.length > 0) {
            const margin = $icon.hasClass('ml-1') ? 'ml-1' : 'mr-1';
            $icon.attr('class', `fas fa-circle-notch fa-spin ${margin}`)
        }
    })
    .on('click', '[data-dismiss="popover"]', function() {
        $(this).closest('.popover').popover('hide')
    })
    .popover({
        container: 'body',
        html: true,
        sanitize: false,
        selector: '[data-toggle="popover"]',
        content() {
            const target = $(this).data('target');
            return $(target).html()
        }
    });

$('select[data-widget="select2"]').select2({
    theme: 'bootstrap4',
    width: '100%',
});
