<?php

namespace App\Http\Controllers;

use App\Contracts\EventSearchInterface;
use App\Event;
use App\Http\Requests\EventSearch;
use App\Http\Requests\EventCreate;
use App\Http\Requests\EventUpdate;

class EventController extends Controller
{
    /**
     * @var EventSearchInterface
     */
    protected $eventSearch;

    /**
     * EventController constructor.
     */
    public function __construct(EventSearchInterface $eventSearch)
    {
        $this->middleware('auth');
        $this->eventSearch = $eventSearch;
    }

    /**
     * @param EventSearch $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(EventSearch $request)
    {
        $userId = auth()->id();
        $fromDate = $request->get('start');
        $toDate = $request->get('end');

        $events = $this->eventSearch
            ->getUserEventsByDate($userId, $fromDate, $toDate, [
                'id',
                'title',
                'date',
            ])->toJson();

        return response()->json($events);
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
            'date' => $request->get('date'),
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

        $status = (bool)$event->delete();

        return response()->json(['status' => $status]);
    }
}
