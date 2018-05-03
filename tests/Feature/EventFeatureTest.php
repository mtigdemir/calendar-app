<?php

namespace Tests\Feature;

use App\Event;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->refreshDatabase();
        $this->user = factory(User::class)->create();
    }

    public function testUserCanSeeOwnEvents()
    {
        // Insert Current User Events
        factory(Event::class)->create(['user_id' => $this->user->id]);
        factory(Event::class)->create(['user_id' => $this->user->id]);

        // Insert different user event
        factory(Event::class)->create(['user_id' => 9999]);

        $this->actingAs($this->user)
            ->get('events')
            ->assertJsonCount(2);
    }

    public function testUserCanVisitNewEventPage()
    {
        $response = $this->actingAs($this->user)
            ->get('events/create');

        $response->assertSee('Create New Event');
    }

    public function testUserCanCreateNewEvent()
    {
        $this->actingAs($this->user)
            ->post('events', [
                'title' => 'Title',
                'date' => '10-10-2016'
            ])
            ->assertSessionHas('message', 'Success!');
    }

    public function testUnAuthorizedUserActionsShouldRedirectToLogin()
    {
        // Create
        $response = $this->get('events/create');
        $response->assertRedirect('login');

        // Store
        $response = $this->post('events');
        $response->assertRedirect('login');
    }

    public function testUnAuthorizedHTTPRequestShouldGet405()
    {
        // Update
        $response = $this->put('events');
        $this->assertEquals(405, $response->getStatusCode());

        // Delete
        $response = $this->delete('events');
        $this->assertEquals(405, $response->getStatusCode());
    }
}
