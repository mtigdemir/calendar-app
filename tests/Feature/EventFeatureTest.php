<?php

namespace Tests\Feature;

use App\User;
use App\Event;
use Illuminate\Auth\Access\AuthorizationException;
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

    public function testUserEventDeletePolicy()
    {
        // Insert Current User Events
        $event = factory(Event::class)->create(['user_id' => 555]);

        $result = $this->actingAs($this->user)
            ->delete('events/' . $event->id)
            ->exception;

        $this->assertInstanceOf(AuthorizationException::class, $result);
    }

    public function testUserEventDelete()
    {
        // Insert Current User Events
        $event = factory(Event::class)->create(['user_id' => $this->user->id]);

        $result = $this->actingAs($this->user)
            ->delete('events/' . $event->id)
            ->decodeResponseJson();

        $this->assertTrue($result['status']);
    }

    public function testEventUpdatePolicy()
    {
        // Insert Event with Different User ID
        $event = factory(Event::class)->create(['user_id' => 999]);

        $result = $this->actingAs($this->user)
            ->put('events/' . $event->id, [
                'title' => 'updated-title',
                'date' => '2020-01-01'
            ])->exception;

        $this->assertInstanceOf(AuthorizationException::class, $result);
    }

    public function testUserCanUpdateEventTitleAndDate()
    {
        // Insert Current User Events
        $event = factory(Event::class)->create(['user_id' => $this->user->id]);

        $result = $this->actingAs($this->user)
            ->put('events/' . $event->id, [
                'title' => 'updated-title',
                'date' => '2020-01-01'
            ])->decodeResponseJson();

        $this->assertEquals('updated-title', $result['title']);
        $this->assertEquals('2020-01-01', $result['date']);
    }

    public function testEventUpdateValidation()
    {
        // Insert Current User Events
        $event = factory(Event::class)->create(['user_id' => $this->user->id]);

        $result = $this->actingAs($this->user)
            ->put('events/' . $event->id, [
                'date' => 'wrong-data'
            ])->exception->getMessage();

        $this->assertEquals('The given data was invalid.', $result);
    }

    public function testEventListDateFormatShouldBeYmd()
    {
        $event = factory(Event::class)->create(['user_id' => $this->user->id]);
        $eventDate = date('Y-m-d', strtotime($event->date));

        $this->actingAs($this->user)
            ->get('events')
            ->assertSee($eventDate);
    }

    public function testEventListShouldIncludeTitleAndDate()
    {
        factory(Event::class)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->get('events')
            ->assertDontSee('user_id')
            ->assertDontSee('created_at')
            ->assertDontSee('updated_at')
            ->assertDontSee('deleted_at')
            ->assertJsonStructure(
                [
                    ['id', 'title', 'date'],
                ]);
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
                'date' => '10-10-2016',
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
