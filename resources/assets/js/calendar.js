// Initialize Calendar
$('.events-calendar').fullCalendar({
    themeSystem: 'bootstrap4',
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listMonth'
    },
    weekNumbers: true,
    eventLimit: true, // allow "more" link when too many events
    events: '/events', // List events from this url
    eventClick: function (event) {
        var modal = $("#eventActionsModal");
        modal.find(".modal-title").html(event.title);
        modal.find("#eventTitle").val(event.title);
        modal.find("#eventDate").val(event.date);
        modal.find("#eventId").val(event.id);
        modal.modal();
    }
});

// Update Event
$('#eventUpdateButton').click(function () {
    var request = $("#eventEditForm").serializeArray();
    var eventId = $('#eventId').val();
    request.push({name: '_method', value: "PUT"});

    $.ajax({
        url: 'events/' + eventId,
        type: 'POST',
        data: request,
        success: function (response) {
            $("#responseMessage").show().html("Updated!");
            location.reload();
        }, error: function (response) {
            var r = jQuery.parseJSON(response.responseText);
            $("#responseMessage").show().html(r.message);
        }
    });
});

// Delete Event
$('#eventDeleteButton').click(function () {
    var request = $("#eventEditForm").serializeArray();
    var eventId = $('#eventId').val();
    request.push({name: '_method', value: "DELETE"});

    $.ajax({
        url: 'events/' + eventId,
        type: 'POST',
        data: request,
        success: function (response) {
            $("#responseMessage").show().html("Deleted!");
            location.reload();
        }, error: function (response) {
            var r = jQuery.parseJSON(response.responseText);
            $("#responseMessage").show().html(r.message);
        }
    });
});