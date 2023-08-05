import $ from 'jquery';
import flatpickr from 'flatpickr';
import select2 from 'select2';

import './bootstrap';

select2($);

$('.alert:not(.alert-important)')
    .delay(5 * 1000)
    .fadeOut(350);

$('body')
    .on('click', 'form :submit', function () {
        const $input = $(this);
        $input.parents('form').find(':submit').data('clicked', false);
        $input.data('clicked', true)
    })
    .on('submit', 'form', function () {
        const $input = $(':submit', this)
            .prop('disabled', true)
            .filter(function () {
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
            const margin = $icon.hasClass('ms-1') ? 'ms-1' : $icon.hasClass('me-1') ? 'me-1' : '';
            $icon.attr('class', `fa-solid fa-circle-notch fa-spin ${margin}`)
        }
    });

flatpickr('[data-widget="datepicker"]', {
    allowInput: true,
    altInput: true,
    altFormat: 'd/m/Y',
    enableTime: false,
    dateFormat: 'Y-m-d',
});

$('[data-widget="select2"]').select2({
    theme: 'bootstrap-5',
    width: '100%',
});
