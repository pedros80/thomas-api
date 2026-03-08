<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

final class TubeControllerTest extends TestCase
{
    public function testListLinesReturnsSuccessfully(): void
    {
        $response = $this->get('api/tube/lines', $this->getAuthHeaders());

        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function testListNaptansByLineReturnsSuccessfully(): void
    {
        $response = $this->get('api/tube/naptans/district', $this->getAuthHeaders());

        $response->assertStatus(200)->assertJson(['success' => true]);

        // $response->dump();
    }

    public function testListArrivalsByNaptanReturnsSuccessfully(): void
    {
        $response = $this->get('api/tube/arrivals/940GZZLUWSM', $this->getAuthHeaders());

        $response->assertStatus(200)->assertJson(['success' => true]);

        $response->dump();
    }
}
