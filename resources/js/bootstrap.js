/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import $ from "jquery";
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
import Cropper from 'cropperjs';
window.Cropper = Cropper;

import Angga from './angga';
import AnggaTables from './anggatables';
import smartWizard from 'smartwizard';
window.smartWizard = smartWizard();
import "smartwizard/dist/css/smart_wizard_all.css";
import select2 from 'select2';
select2();
import 'jstree';
import toastr from 'toastr';
window.$ = $;
window.jQuery = $;
window.Angga = Angga;
window.toastr = toastr;
// Angga.initializeDatePickerIndoView();
window.AnggaTables = AnggaTables;

import Swal from 'sweetalert2'
window.Swal = Swal;
import DataTable from 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
window.DataTable = DataTable;
import "flatpickr/dist/flatpickr.min.css";
import flatpickr from "flatpickr";
import 'datatables.net-buttons-bs5';
import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css';
import 'datatables.net-rowgroup-bs5';
import 'datatables.net-responsive-bs5';
import 'datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css';
import 'datatables.net-buttons/js/buttons.colVis.mjs';
import monthSelectPlugin from "flatpickr/dist/plugins/monthSelect"
import "flatpickr/dist/plugins/monthSelect/style.css";
window.flatpickr = flatpickr;
window.monthSelectPlugin = monthSelectPlugin;
import Inputmask from "inputmask";
window.Inputmask = Inputmask;
var selectorinteger = document.getElementsByClassName("integer-mask");
var iminteger = new Inputmask({
    regex: "^[0-9]*$"
});
iminteger.mask(selectorinteger);

var selectordecimal = document.getElementsByClassName("decimal-mask");
var imdecimal = new Inputmask("decimal", {
    min: 0,
    max: 100
});
imdecimal.mask(selectordecimal);

Inputmask({
    mask: "*{1,50}[.*{1,50}][.*{1,50}][.*{1,50}]@*{1,20}[.*{2,6}][.*{1,2}]",
    greedy: false,
    onBeforePaste: function (pastedValue, opts) {
        pastedValue = pastedValue.toLowerCase();
        return pastedValue.replace("mailto:", "");
    },
    definitions: {
        "*": {
            validator: '[0-9A-Za-z!#$%&"*+/=?^_`{|}~\-]',
            cardinality: 1,
            casing: "lower"
        }
    }
}).mask(".email-mask");
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

import '../css/datatables.css';
import '../css/cropper.min.css';