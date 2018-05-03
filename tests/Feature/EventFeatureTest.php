<?php

namespace Tests\Feature;

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
            ->assertSessionHas('message','Success!');
    }
}
