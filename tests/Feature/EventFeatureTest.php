<?php

namespace Tests\Feature;

use App\User;
use App\Event;
use Tests\TestCase;
use Illuminate\Auth\Access\AuthorizationException;
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
            ->delete('events/'.$event->id)
            ->exception;

        $this->assertInstanceOf(AuthorizationException::class, $result);
    }

    public function testUserEventDelete()
    {
        // Insert Current User Events
        $event = factory(Event::class)->create(['user_id' => $this->user->id]);

        $result = $this->actingAs($this->user)
            ->delete('events/'.$event->id)
            ->decodeResponseJson();

        $this->assertTrue($result['status']);
    }

    public function testEventUpdatePolicy()
    {
        // Insert Event with Different User ID
        $event = factory(Event::class)->create(['user_id' => 999]);

        $result = $this->actingAs($this->user)
            ->put('events/'.$event->id, [
                'title' => 'updated-title',
                'date' => '2020-01-01',
            ])->exception;

        $this->assertInstanceOf(AuthorizationException::class, $result);
    }

    public function testUserCanUpdateEventTitleAndDate()
    {
        // Insert Current User Events
        $event = factory(Event::class)->create(['user_id' => $this->user->id]);

        $result = $this->actingAs($this->user)
            ->put('events/'.$event->id, [
                'title' => 'updated-title',
                'date' => '2020-01-01',
            ])->decodeResponseJson();

        $this->assertEquals('updated-title', $result['title']);
        $this->assertEquals('2020-01-01', $result['date']);
    }

    public function testEventUpdateValidation()
    {
        // Insert Current User Events
        $event = $this->createEventForToday();

        $result = $this->actingAs($this->user)
            ->put('events/'.$event->id, [
                'date' => 'wrong-data',
            ])->exception->getMessage();

        $this->assertEquals('The given data was invalid.', $result);
    }

    public function testEventListDateFormatShouldBeYmd()
    {
        $this->createEventForToday();
        $result = $this->eventListCall()->getContent();

        $regex = '/'.date('Y-m-d').'/';
        $this->assertRegexp($regex, $result);
    }

    public function testEventListShouldIncludeTitleAndDate()
    {
        $this->createEventForToday();

        $result = $this->eventListCall()
            ->assertDontSee('user_id')
            ->assertDontSee('created_at')
            ->assertDontSee('updated_at')
            ->assertDontSee('deleted_at')
            ->json();

        // Revert First Element of the Json Response
        $result = json_decode($result, true)[0];

        // id, title, date should be exists for each element
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('date', $result);

        // user_id, created_at, updated_at, deleted_at should be hidden
        $this->assertArrayNotHasKey('user_id', $result);
        $this->assertArrayNotHasKey('created_at', $result);
        $this->assertArrayNotHasKey('updated_at', $result);
        $this->assertArrayNotHasKey('deleted_at', $result);
    }

    public function testUserCanSeeOwnEvents()
    {
        // Insert Current User Events
        $this->createEventForToday();
        $this->createEventForToday();

        // Insert different user event
        $this->createEventForToday(9999);

        $result = $this->eventListCall()
            ->assertSee(date('Y-m-d'))
            ->json();

        $this->assertEquals(2, count(json_decode($result, true)));
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

    private function createEventForToday($userId = null)
    {
        // Creating event for different user is useful for testing
        if ($userId == null) {
            $userId = $this->user->id;
        }

        return factory(Event::class)->create(
            [
                'user_id' => $userId,
                'date' => date('Y-m-d'),
            ]);
    }

    private function eventListCall($date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d');
        }

        return $this->actingAs($this->user)
            ->call('GET', 'events', [
                'start' => $date,
                'end' => $date,
            ]);
    }
}
