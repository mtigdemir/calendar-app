/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

// Bootstrap
require('./bootstrap');

// Full Calendar
require('fullcalendar');

// Ajax X-XSRF-TOKEN add to token
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.events-calendar').fullCalendar({
    themeSystem: 'bootstrap4',
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listMonth'
    },
    weekNumbers: true,
    eventLimit: true, // allow "more" link when too many events
    events: '/events',
    eventClick: function (event) {
        var modal = $("#eventEditModal");
        modal.find(".modal-title").html(event.title);
        modal.find("#eventTitle").val(event.title);
        modal.find("#eventDate").val(event.date);
        modal.find("#eventId").val(event.id);
        modal.modal();
    }
});

$('#eventUpdateButton').click(function () {
    var eventId = $("#eventId").val();

    console.log($("#eventEditForm"));
    console.log($("#eventEditForm").serializeArray());
    $.ajax({
        url: 'events/'+eventId,
        type: 'POST',
        data: $("#eventEditForm").serializeArray(),
        success: function(response) {
            $("#responseMessage").show().html("Updated!");
            location.reload();
        },error: function (response) {
            var r = jQuery.parseJSON(response.responseText);
            $("#responseMessage").show().html(r.message);
        }
    });
});