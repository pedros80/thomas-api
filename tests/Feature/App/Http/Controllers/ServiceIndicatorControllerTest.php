<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

final class ServiceIndicatorControllerTest extends TestCase
{
    public function testGetServiceIndicatorReturnsSuccessfully(): void
    {
        $response = $this->get('api/service-indicator', $this->getAuthHeaders());

        $response->assertStatus(200)->assertJson(['success' => true]);
    }
}
