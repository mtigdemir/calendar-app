/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

// Full Calendar
require('fullcalendar');

$('.events-calendar').fullCalendar({
    themeSystem: 'bootstrap4',
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listMonth'
    },
    weekNumbers: true,
    eventLimit: true, // allow "more" link when too many events
    events: '/api/v1/events'
});