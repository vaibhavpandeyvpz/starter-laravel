window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');
require('bootstrap');
require('flatpickr');
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
            const margin = $icon.hasClass('ml-1') ? 'ml-1' : $icon.hasClass('mr-1') ? 'mr-1' : '';
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
            const target = $(this).data('target') || $(this).attr('href');
            return $(target).html()
        }
    });

$('.custom-file-input').on('change', function (e) {
    const name = e.target.files[0].name;
    $(this).next('.custom-file-label').text(name)
});

$('[data-toggle="tooltip"]').tooltip({ container: 'body' });

$('[data-widget="datepicker"]').flatpickr({
    allowInput: true,
    altInput: true,
    altFormat: 'd/m/Y',
    enableTime: false,
    dateFormat: 'Y-m-d',
});

$('[data-widget="datetimepicker"]').flatpickr({
    allowInput: true,
    altInput: true,
    altFormat: 'd/m/Y H:i:00',
    enableTime: true,
    dateFormat: 'Y-m-d H:i:00',
});

$('[data-widget="timepicker"]').flatpickr({
    allowInput: true,
    enableTime: true,
    noCalendar: true,
    dateFormat: 'H:i:00',
});

$('[data-widget="select2"]').select2({
    theme: 'bootstrap4',
});

$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus()
});

$('#flash-overlay-modal').modal('show');
