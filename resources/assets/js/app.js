/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

// Bootstrap
require('./bootstrap');

// Full Calendar
require('fullcalendar');

// Datetime Picker and Moment
global.moment = require('moment');
require('tempusdominus-bootstrap-4');

// Calendar CRUD Actions
require('./calendar');

// Ajax X-XSRF-TOKEN add to token
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function() {
    $('.datetimepicker-input').datetimepicker({
        format:"YYYY-MM-DD"
    });
});