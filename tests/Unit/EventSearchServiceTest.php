<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\User;
use App\Event;
use Tests\TestCase;
use App\Services\EventSearchService;
use App\Contracts\EventSearchInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventSearchServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var EventSearchInterface
     */
    protected $eventSearchService;

    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->refreshDatabase();
        $this->user = factory(User::class)->create();
        $this->eventSearchService = new EventSearchService();
    }

    public function testGetUserEventsShouldReturnExactDates()
    {
        $this->createEventByDate($this->getDate('+10 day'));
        $this->createEventByDate($this->getDate());

        // We expect to get only 1 event which belongs to today
        $result = $this->eventSearchService->getUserEventsByDate(
            $this->user->id,
            $this->getDate(),
            $this->getDate()
        );

        $this->assertEquals(1, count($result));
    }

    public function testGetUserEventsByDate()
    {
        $this->createEventByDate();
        $this->createEventByDate();
        $this->createEventByDate();

        $result = $this->eventSearchService->getUserEventsByDate(
            $this->user->id,
            $this->getDate('-2 day'),
            $this->getDate('+2 day')
        );

        $this->assertEquals(3, count($result->toArray()));
    }

    private function createEventByDate($date = null)
    {
        if ($date == null) {
            $date = $this->getDate(); // If the date is empty Initialize as today
        }

        return factory(Event::class)->create([
            'user_id' => $this->user->id,
            'date' => $date,
        ]);
    }

    private function getDate($time = '')
    {
        return date('Y-m-d', time($time));
    }
}
