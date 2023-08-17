import { autocomplete } from '@algolia/autocomplete-js';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import persist from '@alpinejs/persist';
import { Tooltip } from 'bootstrap';
import flatpickr from 'flatpickr';
import $ from 'jquery';
import select2 from 'select2';
import './bootstrap';

Alpine.plugin(collapse);
Alpine.plugin(persist);

select2(window, $);

window.Alpine = Alpine;
window.$ = window.jQuery = $;

$.fn.extend({
    datepicker() {
        return this.each(function() {
            flatpickr(this, {
                allowInput: true,
                altInput: true,
                altFormat: 'd/m/Y',
                enableTime: false,
                dateFormat: 'Y-m-d',
            });
        });
    },
    dropdown() {
        return this.each(function() {
            $(this).select2({
                theme: 'bootstrap-5',
                width: '100%',
            });
        });
    },
    search({ placeholder, source, ...templates }) {
        return this.each(function() {
            const $this = $(this);
            autocomplete({
                container: this,
                placeholder: placeholder,
                getSources({ query: q }) {
                    return [{
                        getItems() {
                            return axios.get(source, { params: { q } })
                                .then(({ data }) => data.data);
                        },
                        getItemUrl({ item }) {
                            return item.url;
                        },
                        onSelect({ item }) {
                            $this.trigger('change', item);
                        },
                        sourceId: 'primary',
                        templates: {
                            header({ html, items }) {
                                if (items.length) {
                                    return html`
                                        <p class="small text-muted text-center">Showing ${items.length} results.</p>
                                    `;
                                }
                            },
                            noResults({ html }) {
                                return html`<p class="small text-muted text-center mb-0">No results found.</p>`;
                            },
                            ...templates,
                        },
                    }];
                },
            });
        });
    },
});

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

const opened = document.querySelector('.modal[data-bs-modal-open="true"]');
if (opened) {
    Modal.getOrCreateInstance(opened).show();
}

$('[data-widget="datepicker"]').datepicker();

$('[data-widget="dropdown"]').dropdown();

([].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')))
    .forEach((el) => new Tooltip(el));

Alpine.start();
