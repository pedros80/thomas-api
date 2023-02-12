<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

final class RealTimeIncidentsControllerTest extends TestCase
{
    public function testGetRTIReturnsSuccessfully(): void
    {
        $response = $this->get('api/rti');

        $response->assertStatus(200)->assertJson(['success' => true]);
    }
}
