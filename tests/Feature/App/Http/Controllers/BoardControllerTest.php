<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

final class BoardControllerTest extends TestCase
{
    public function testDeparturesInvalidStationCodeThrowsException(): void
    {
        $response = $this->get('api/boards/departures/invalid');

        $response->assertStatus(400)->assertJson(['success' => false]);
    }

    public function testDeparturesValidStationCodeReturnsSuccessfully(): void
    {
        $response = $this->get('api/boards/departures/gtw');

        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function testDeparturesPlatformValidStationCodeReturnsSuccessfully(): void
    {
        $response = $this->get('api/boards/departures/dam/platform/2');

        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function testArrivalsValidStationCodeReturnsSuccessfully(): void
    {
        $response = $this->get('api/boards/arrivals/dam');

        $response->assertStatus(200)->assertJson(['success' => true]);
    }
}
