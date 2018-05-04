<?php

declare(strict_types=1);

namespace App\Services;

use App\Event;
use App\Contracts\EventSearchInterface;

class EventSearchService implements EventSearchInterface
{
    /**
     * @var Event
     */
    protected $events;

    public function getUserEventsByDate($userId, $fromDate, $toDate, $columns = ['*'])
    {
        $this->events = Event::where('user_id', $userId)
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->get($columns);

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->events->toArray();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return $this->events->toJson();
    }
}
