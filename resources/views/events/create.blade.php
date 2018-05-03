<div class="card-header bg-light">
    Create New Event
</div>
<div class="card-body">
    @include('shared.errors')
    <div class="col-lg">
        <form method="post" action="{{@route('events.store')}}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input name="title" type="text" class="form-control" placeholder="Event Title" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Date</label>
                <div class="col-sm-10">
                    <div class="input-group datetimepicker-input" id="datetimepickerCreate" data-target-input="nearest">
                        <input name="date" type="text" class="form-control"
                               data-target="#datetimepickerCreate" placeholder="Event Date" required/>
                        <div class="input-group-append" data-target="#datetimepickerCreate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</div>