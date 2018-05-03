<?php

namespace Tests\Unit;

use App\User;
use App\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testEventBelongsToUser()
    {
        $event = factory(Event::class)->create();

        $this->assertInstanceOf(User::class, $event->user);
    }
}
