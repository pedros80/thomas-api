<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

final class NewsControllerTest extends TestCase
{
    public function testGetNewsReturnsSuccessfully(): void
    {
        $response = $this->get('api/news');

        $response->assertStatus(200)->assertJson(['success' => true]);
    }
}
