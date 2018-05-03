<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\EventUpdate;
use Illuminate\Http\Request;
use App\Http\Requests\EventCreate;

class EventController extends Controller
{
    protected $user;

    /**
     * EventController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = $request->user()->events()->get([
            'id',
            'title',
            'date',
        ]);

        return response()->json($events->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventCreate $eventCreate
     * @return \Illuminate\Http\Response
     */
    public function store(EventCreate $eventCreate)
    {
        Event::create([
            'user_id' => \auth()->user()->getAuthIdentifier(),
            'title' => $eventCreate->get('title'),
            'date' => $eventCreate->get('date'),
        ]);

        return back()->with('message', 'Success!');
    }

    public function update(EventUpdate $request, Event $event)
    {
        $this->authorize('update', $event);

        $event->update([
            'title' => $request->get('title'),
            'date' => $request->get('date')
        ]);

        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
