@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-7">
            <div class="card-header bg-light">
                My Events Calendar
            </div>
            <div class="card-body">
                <div class="events-calendar"></div>
            </div>
        </div>
        <div class="col-5">
            @include('events.create')
        </div>
    </div>

    @include('events.actionsModal')
@endsection
