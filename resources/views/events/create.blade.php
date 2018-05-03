@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg">
        <h2>Create New Event</h2>
        <form method="post" action="{{@route('events.store')}}">
            @csrf
            <div class="row">
                <div class="col">
                    <input type="text" name="title"  class="form-control" placeholder="Title">
                </div>
                <div class="col">
                    <input type="date" name="date" class="form-control" placeholder="Event Date">
                </div>
            </div>

            <br>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>

        @include('shared.errors')
    </div>
</div>
@endsection