/*
 * This base file exists to provide a single place to import all the
 * appropriate functionality and/or libraries that you will need to
 * run the site.
 *
 * It's only client-side, but it exists to mitigate the mess that was the
 * old common.js file.
 *
 * - Stella
 */

// TOOLTIPS - Initialization
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
[...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

// BOOTSTRAP SELECT - Initialization
const jqueryBody = $('body');
jqueryBody.on('DOMNodeInserted', (e) => $(e.target).find('.selectpicker').selectpicker());

// CKEDITOR - Initialization
const initCKEditor = (root) => {
    root.find('.ckeditor').each((i, e) => {
        // Deduplicate
        const element = $(e);
        if (element.hasClass('ckeditor-applied')) return;
        element.addClass('ckeditor-applied');

        ClassicEditor
            .create(e)
            .then(editor => {
                // Auto-save
                editor.model.document.on('change:data', () => {
                    // Update the textarea
                    editor.updateSourceElement();
                });
            })
            .catch(error => console.error(error));
    });
};

$(document).ready(() => initCKEditor(jqueryBody));
jqueryBody.on('DOMNodeInserted', (e) => initCKEditor($(e.target)));

// COMPATIBILITY
// TODO: Remove these
const baseURL = window.origin + "/";

// SELECT2 - Initialization
// Set defaults
$.fn.select2.defaults.set('theme', 'bootstrap-5');
$.fn.select2.defaults.set('width', '100%');

// Fix Select2 Bootstrap modal scroll bug
$(document).on('select2:close', 'select2', function(e) {
    $(e.target).parents().off('scroll.select2')
    $(window).off('scroll.select2')
});

function initComponent(i, e) {
    // Check if the element is a multiselect
    const isMulti = $(e).hasClass('multiselect');
    $(e).select2({
        theme: 'bootstrap-5',
        placeholder: isMulti ? 'Select Options' : 'Select Option',
        multiple: isMulti,
        allowClear: true,
        dropdownParent: $(this).parent()
    });
}

$(document).ready(() => $('.select2').each(initComponent));
jqueryBody.on('DOMNodeInserted', (e) => $(e.target).find('.select2').each(initComponent));

// SWAL - Initialization
// noinspection JSUnusedGlobalSymbols
window.Popup = Swal.mixin({
    // Bootstrap 5
    customClass: {
        confirmButton: 'btn btn-success btn-lg',
        cancelButton: 'btn btn-danger btn-lg'
    },
    buttonsStyling: false,

    // Timers
    timer: 3000,
    timerProgressBar: true,
});

// Auto-select search
$(document).on('select2:open', () => {
    // Yes, this timeout is necessary to support multiple
    // select2 elements on the same page.
    setTimeout(() => {
        document.querySelector('.select2-container--open .select2-search__field')?.focus();
    }, 0);
});

// Automatic address autocompletion
$(document).ready(() => {
    // Listen for changes on all country selections
    $('.country-select').change(function () {
        // Get the state dropdown
        const stateDropdown = $(this).closest('.address-form').find('.state-select');
        if (!stateDropdown) return;

        $(stateDropdown).select2({
            theme: 'bootstrap-5',
            placeholder: 'Select State',
            ajax: {
                url: `${window.SSR.routes['data:getStateList']}/${$(this).val()}`,
                dataType: 'json',
                delay: 250,
                processResults: (data) => ({results: data.map((entry) => ({id: entry.id, text: entry.name}))}),
                cache: true
            }
        });

        // Clear the state dropdown
        stateDropdown.empty();

        // Clear the city & postcode fields
        $(this).closest('.address-form').find('.city-select')?.empty();
        $(this).closest('.address-form').find('.postcode-field')?.val('');
    });

    // Listen for changes on all state selections
    $('.state-select').change(function () {
        // Get the city dropdown
        const cityDropdown = $(this).closest('.address-form').find('.city-select');
        if (!cityDropdown) return;

        $(cityDropdown).select2({
            theme: 'bootstrap-5',
            placeholder: 'Select City',
            ajax: {
                url: `${window.SSR.routes['data:getCityList']}/${$(this).val()}`,
                dataType: 'json',
                delay: 250,
                processResults: (data) => ({results: data}),
                cache: true
            }
        });

        // Clear the city dropdown
        cityDropdown.empty();

        // Clear the postcode field
        $(this).closest('.address-form').find('.postcode-field')?.val('');
    });

    // Listen for changes on all city selections
    $('.city-select').change(function () {
        // Get the postcode field
        const postcodeField = $(this).closest('.address-form').find('.postcode-field');
        if (!postcodeField) return;

        // Request the postcode for the selected city
        $.getJSON(`${window.SSR.routes['data:getCityPostCode']}/${$(this).val()}`, (data) => {
            // Set the postcode
            postcodeField.val(data);
        });
    });
});

// QUOTES - Edit
$(document).ready(() => {
    const fillSalesperson = () => {
        // Get the salesperson dropdown
        const salespersonDropdown = $('#salesperson');
        if (!salespersonDropdown) return;

        // Update the salesperson dropdown
        $.post(window.SSR.routes['quotes:getSalesPerson'], {id: $('#quote_customer').val()}, (data) => {
            // Add the entries
            salespersonDropdown.empty();
            salespersonDropdown.append(data);

            // Select the first entry with a value
            salespersonDropdown.find('option[value!=""]').first().prop('selected', true);
        });
    };

    // Setup autofilling for the customer name
    $('#quote_company').change(function () {
        // Get the customer dropdown
        const customerDropdown = $('#quote_customer');
        if (!customerDropdown) return;

        // Update the customer dropdown
        $.post(window.SSR.routes['quotes:getCustomer'], {company: $(this).val()}, (data) => {
            // Add the entries
            customerDropdown.empty();
            customerDropdown.append(data);

            // Select the first entry with a value
            customerDropdown.find('option[value!=""]').first().prop('selected', true);

            // Fill the salesperson
            fillSalesperson();
        });
    });

    // Setup autofilling for the salesperson
    $('#quote_customer').change(function () {
        // Fill the salesperson
        fillSalesperson();
    });
});

// TODO: Re-implement
/*!
 * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
 * Copyright 2011-2023 The Bootstrap Authors
 * Licensed under the Creative Commons Attribution 3.0 Unported License.
 */

// (() => {
//     'use strict'
//
//     const getStoredTheme = () => localStorage.getItem('theme')
//     const setStoredTheme = theme => localStorage.setItem('theme', theme)
//
//     const getPreferredTheme = () => {
//         const storedTheme = getStoredTheme()
//         if (storedTheme) {
//             return storedTheme
//         }
//
//         return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
//     }
//
//     const setTheme = theme => {
//         if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
//             document.documentElement.setAttribute('data-bs-theme', 'dark')
//         } else {
//             document.documentElement.setAttribute('data-bs-theme', theme)
//         }
//     }
//
//     setTheme(getPreferredTheme())
//
//     const showActiveTheme = (theme, focus = false) => {
//         const themeSwitcher = document.querySelector('#bd-theme')
//
//         if (!themeSwitcher) {
//             return
//         }
//
//         const themeSwitcherText = document.querySelector('#bd-theme-text')
//         const activeThemeIcon = document.querySelector('.theme-icon-active use')
//         const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
//         const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href')
//
//         document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
//             element.classList.remove('active')
//             element.setAttribute('aria-pressed', 'false')
//         })
//
//         btnToActive.classList.add('active')
//         btnToActive.setAttribute('aria-pressed', 'true')
//         activeThemeIcon.setAttribute('href', svgOfActiveBtn)
//         const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`
//         themeSwitcher.setAttribute('aria-label', themeSwitcherLabel)
//
//         if (focus) {
//             themeSwitcher.focus()
//         }
//     }
//
//     window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
//         const storedTheme = getStoredTheme()
//         if (storedTheme !== 'light' && storedTheme !== 'dark') {
//             setTheme(getPreferredTheme())
//         }
//     })
//
//     window.addEventListener('DOMContentLoaded', () => {
//         showActiveTheme(getPreferredTheme())
//
//         document.querySelectorAll('[data-bs-theme-value]')
//             .forEach(toggle => {
//                 toggle.addEventListener('click', () => {
//                     const theme = toggle.getAttribute('data-bs-theme-value')
//                     setStoredTheme(theme)
//                     setTheme(theme)
//                     showActiveTheme(theme, true)
//                 })
//             })
//     })
// })()