<?php

namespace Tests\Unit;

use App\Event;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
