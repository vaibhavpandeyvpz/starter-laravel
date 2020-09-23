window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');
require('bootstrap');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('form :submit').click(function() {
    const $input = $(this);
    $input.parents('form').find(':submit').data('clicked', false);
    $input.data('clicked', true)
});

$('form').on('submit', function () {
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
});
