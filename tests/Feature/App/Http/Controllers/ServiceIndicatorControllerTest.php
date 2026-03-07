<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

final class ServiceIndicatorControllerTest extends TestCase
{
    public function testInvalidSortThrowsException(): void
    {
        $response = $this->get('api/service-indicator?sort=invalid', $this->getAuthHeaders());

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson(['errors' => [
                [
                    'code'   => 400,
                    'title'  => 'Invalid Sort',
                    'detail' => 'invalid is not a valid Sort',
                ],
            ]]);
    }

    public function testInvalidOrderByThrowsException(): void
    {
        $response = $this->get('api/service-indicator?orderBy=invalid', $this->getAuthHeaders());

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson(['errors' => [
                [
                    'code'   => 400,
                    'title'  => 'Invalid Order By',
                    'detail' => 'invalid is not a valid Order By',
                ],
            ]]);
    }

    public function testInvalidPerPageThrowsException(): void
    {
        $response = $this->get('api/service-indicator?perPage=-1', $this->getAuthHeaders());

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson(['errors' => [
                [
                    'code'   => 400,
                    'title'  => 'Invalid Per Page',
                    'detail' => 'Invalid PerPage -1 - must be greater than 0',
                ],
            ]]);
    }

    public function testInvalidPageNumberThrowsException(): void
    {
        $response = $this->get('api/service-indicator?page=-1', $this->getAuthHeaders());

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson(['errors' => [
                [
                    'code'   => 400,
                    'title'  => 'Invalid Page Number',
                    'detail' => 'Invalid PageNumber -1 - must be greater than 0',
                ],
            ]]);
    }

    public function testGetServiceIndicatorReturnsSuccessfully(): void
    {
        $response = $this->get('api/service-indicator', $this->getAuthHeaders());

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJson(['pagination' => [
                'page'       => 1,
                'perPage'    => 15,
                'total'      => 31,
                'totalPages' => 3,
                'next'       => 2,
            ]]);
    }
}
