window._ = require('lodash');

window.$ = window.jQuery = require('jquery');
window.Tether = require('Tether');
window.swal = require('sweetalert');

require('bootstrap/js/src/alert');
require('bootstrap/js/src/button');
require('bootstrap/js/src/carousel');
require('bootstrap/js/src/collapse');
require('bootstrap/js/src/dropdown');
require('bootstrap/js/src/modal');
require('bootstrap/js/src/popover');
require('bootstrap/js/src/scrollspy');
require('bootstrap/js/src/tab');
require('bootstrap/js/src/util');
// require('bootstrap/js/src/tooltip');

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.AIMED.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

window.$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': window.AIMED.csrfToken }
});