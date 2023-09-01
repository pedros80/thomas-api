<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

final class BoardControllerTest extends TestCase
{
    public function testDeparturesInvalidStationCodeThrowsException(): void
    {
        $response = $this->get('api/boards/departures/invalid', $this->getAuthHeaders());

        $response->assertStatus(400)->assertJson(['success' => false]);
    }

    public function testDeparturesValidStationCodeReturnsSuccessfully(): void
    {
        $response = $this->get('api/boards/departures/dam', $this->getAuthHeaders());

        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function testDeparturesPlatformValidStationCodeReturnsSuccessfully(): void
    {
        $response = $this->get('api/boards/departures/dam/platform/2', $this->getAuthHeaders());

        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function testArrivalsValidStationCodeReturnsSuccessfully(): void
    {
        $response = $this->get('api/boards/arrivals/dam', $this->getAuthHeaders());

        $response->assertStatus(200)->assertJson(['success' => true]);
    }
}
