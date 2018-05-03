<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\EventUpdate;
use Illuminate\Http\Request;
use App\Http\Requests\EventCreate;

class EventController extends Controller
{

    /**
     * EventController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * @param EventCreate $eventCreate
     * @return \Illuminate\Http\RedirectResponse
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

    /**
     * @param EventUpdate $request
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
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
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Event $event)
    {
        $this->authorize('destroy', $event);

        $status = (boolean)$event->delete();

        return response()->json(['status' => $status]);
    }
}
