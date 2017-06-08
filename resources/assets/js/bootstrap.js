window.$ = window.jQuery = require('jquery');
window._ = require('lodash');
window.axios = require('axios');
window.numeral = require('numeral');
window.Pusher = require('pusher-js');
require('bootstrap-sass');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}