<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

final class StationControllerTest extends TestCase
{
    public function testSearchingKnownStationReturnsSuccessfully(): void
    {
        $response = $this->post('api/stations/search', ['search' => 'dalmeny']);

        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function testGetStationsMessagesReturnsSuccessfully(): void
    {
        $response = $this->get('api/stations/messages/DAM');

        $response->assertStatus(200)->assertJson(['success' => true]);
    }
}
