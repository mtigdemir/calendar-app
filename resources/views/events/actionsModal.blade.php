<div class="modal fade" id="eventEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="eventEditForm">
                    <div class="form-group">
                        <label for="eventTitle" class="col-form-label">Title:</label>
                        <input name="title" type="text" class="form-control" id="eventTitle">
                    </div>
                    <div class="form-group">
                        <label for="eventDate" class="col-form-label">Date:</label>
                        <div class="input-group datetimepicker-input" id="datetimepickerModal" data-target-input="nearest">
                            <input id="eventDate" name="date" type="text" class="form-control"
                                   data-target="#datetimepickerModal" placeholder="Event Date" required/>
                            <div class="input-group-append" data-target="#datetimepickerModal" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="eventId">
                </form>
            </div>
            <div class="alert alert-info text-center" style="display: none;" id="responseMessage"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                <button id="eventUpdateButton" type="button" class="btn btn-warning">Update Event</button>
                <button id="eventDeleteButton" type="button" class="btn btn-danger">Delete Event</button>
            </div>
        </div>
    </div>
</div>