<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

final class NewsControllerTest extends TestCase
{
    public function testGetNewsReturnsSuccessfully(): void
    {
        $response = $this->get('api/news', $this->getAuthHeaders());

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJson([
                'pagination' => [
                    'page'    => 1,
                    'perPage' => 15,
                ],
            ]);
    }

    public function testGetNewsPaginationReturnsSuccessfully(): void
    {
        $response = $this->get('api/news?perPage=1&page=2', $this->getAuthHeaders());

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJson([
                'pagination' => [
                    'page'    => 2,
                    'perPage' => 1,
                ],
            ]);
    }

    public function testGetNewsInvalidSortThrowsException(): void
    {
        $response = $this->get('api/news?sort=Invalid', $this->getAuthHeaders());

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson([
                'errors' => [
                    [
                        'code'   => 400,
                        'title'  => 'Invalid Sort',
                        'detail' => 'Invalid is not a valid Sort',
                    ],
                ],
            ]);
    }

    public function testGetNewsInvalidOrderByThrowsException(): void
    {
        $response = $this->get('api/news?orderBy=id', $this->getAuthHeaders());

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson([
                'errors' => [
                    [
                        'code'   => 400,
                        'title'  => 'Invalid Order By',
                        'detail' => 'id is not a valid Order By',
                    ],
                ],
            ]);
    }
}
