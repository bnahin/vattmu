window.$ = window.jQuery = require('jquery')
require('./bootstrap');

/** Custom JS */
$('div.flash-alert').not('.alert-important').delay(3000).fadeOut(500);