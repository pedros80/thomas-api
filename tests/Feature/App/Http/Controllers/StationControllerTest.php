<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

final class StationControllerTest extends TestCase
{
    public function testSearchingKnownStationReturnsSuccessfully(): void
    {
        $response = $this->post('api/stations/search', ['search' => 'dalmeny'], $this->getAuthHeaders());

        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function testGetStationsMessagesReturnsSuccessfully(): void
    {
        $response = $this->get('api/stations/messages/DAM', $this->getAuthHeaders());

        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function testMissingSearchParameterThrowsException(): void
    {
        $response = $this->post('api/stations/search', ['searchy' => 'dalmeny'], $this->getAuthHeaders());

        $response->assertStatus(400)->assertJson(['success' => false])->assertJson(['errors' => 'The search field is required.']);
    }
}
