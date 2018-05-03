<?php

namespace Tests\Unit;

use App\User;
use App\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testUserHasManyEventEvents()
    {
        $user = factory(User::class)->create();
        $events = factory(Event::class, 4)->create(['user_id' => $user->id]);

        $this->assertEquals($events->count(), $user->events()->count());
    }
}
