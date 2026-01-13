/**
 * jQuery (WAJIB PALING ATAS)
 */
import $ from "jquery";
window.$ = window.jQuery = $;


/**
 * Axios
 */
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 * Library umum
 */
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
window.toastr = toastr;

import Swal from 'sweetalert2'
window.Swal = Swal;

window.Angga = Angga;
window.AnggaTables = AnggaTables;


/**
 * =========================
 * DATATABLES (URUTAN PENTING)
 * =========================
 */

// CORE
import DataTable from 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
window.DataTable = DataTable;

// // EXTENSIONS (SETELAH CORE)

// // Buttons
// import 'datatables.net-buttons-bs5';
// import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css';
// import 'datatables.net-buttons/js/buttons.colVis.mjs';

// // Select (WAJIB UNTUK SEARCHPANES)
// import 'datatables.net-select-bs5';
// import 'datatables.net-select-bs5/css/select.bootstrap5.min.css';

// // SearchPanes
// import 'datatables.net-searchpanes-bs5';
// import 'datatables.net-searchpanes-bs5/css/searchPanes.bootstrap5.min.css';

// // Responsive
// import 'datatables.net-responsive-bs5';
// import 'datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css';

// // RowGroup (opsional)
// import 'datatables.net-rowgroup-bs5';


/**
 * Flatpickr
 */
import "flatpickr/dist/flatpickr.min.css";
import flatpickr from "flatpickr";
import monthSelectPlugin from "flatpickr/dist/plugins/monthSelect"
import "flatpickr/dist/plugins/monthSelect/style.css";
window.flatpickr = flatpickr;
window.monthSelectPlugin = monthSelectPlugin;


/**
 * Inputmask
 */
import Inputmask from "inputmask";
window.Inputmask = Inputmask;

new Inputmask({ regex: "^[0-9]*$" }).mask(".integer-mask");

new Inputmask("decimal", { min: 0, max: 100 }).mask(".decimal-mask");

Inputmask('numeric', {
    radixPoint: ",",
    rightAlign: false,
    digits: 2,
}).mask('.decimal-mask-morethan');

Inputmask({
    mask: "*{1,50}[.*{1,50}][.*{1,50}][.*{1,50}]@*{1,20}[.*{2,6}][.*{1,2}]",
    greedy: false
}).mask(".email-mask");

Inputmask('numeric', {
    radixPoint: ",",
    allowMinus: false,
    groupSeparator: ".",
    rightAlign: false,
    digits: 2,
}).mask('.money-mask');


/**
 * Compressor
 */
import Compressor from 'compressorjs';
window.Compressor = Compressor;


/**
 * CSS tambahan
 */
import '../css/datatables.css';
import '../css/cropper.min.css';


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });