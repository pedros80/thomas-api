<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

final class RealTimeIncidentsControllerTest extends TestCase
{
    public function testGetRTIReturnsSuccessfully(): void
    {
        $response = $this->get('api/rti', $this->getAuthHeaders());

        $response->assertStatus(200)->assertJson(['success' => true]);
    }
}
