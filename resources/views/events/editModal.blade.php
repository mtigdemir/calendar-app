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
                        <input name="date" class="form-control" id="eventDate"/>
                    </div>
                    <input type="hidden" id="eventId">
                    <input name="_method" type="hidden" value="PUT">
                </form>
            </div>
            <div class="alert alert-info text-center" style="display: none;" id="responseMessage"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button id="eventUpdateButton" type="button" class="btn btn-primary">Update Event</button>
            </div>
        </div>
    </div>
</div>