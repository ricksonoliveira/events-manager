<?php

namespace Tests\Unit;

use Tests\TestCase;

class EventsTest extends TestCase
{
    public $event = [];

    public function __construct()
    {
        TestCase::__construct();
        $this->event = [
            'id' => null,
            'title' => 'Mocked Event',
            'description' => 'Mocked event description',
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => now()->addDay()->format('Y-m-d H:i:s')
        ];
    }


    public function testCanCreateValidEvent()
    {
        $event = $this->event;
        $response = $this->json('POST', 'api/events/save', $event);
        $response->assertStatus(200);
    }

    public function testCanRetrieveValidEvent()
    {
        $event = $this->event;
        $event['id'] = 1;
        $response = $this->json('GET', "api/events/view/$event[id]", $event);
        $response->assertStatus(200);
    }

    public function testCanUpdateValidEvent()
    {
        $event = $this->event;

        $event['id'] = 1;
        $event['title'] = 'Event Title Updated';
        $event['description'] = 'Event Description Updated';
        $event['start_date'] = now()->format('Y-m-d H:i:s');
        $event['end_date'] = now()->format('Y-m-d H:i:s');

        $response = $this->json('PUT', "api/events/update/$event[id]", $event);
        $response->assertStatus(200);
    }

    public function testCanDeleteValidEvent()
    {
        $event = $this->event;
        $event['id'] = 1;
        $response = $this->json('DELETE', "api/events/delete/$event[id]", $event);
        $response->assertStatus(200);
    }
}
