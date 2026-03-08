<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Faker\Factory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Thomas\Users\Domain\UserId;

final class UserControllerTest extends TestCase
{
    public function testAddNoSignatureThrowsException(): void
    {
        $response = $this->post('api/users');

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson([
                'errors' => [
                    [
                        'code'   => 400,
                        'title'  => 'Invalid Fat Controller Request',
                        'detail' => 'You have caused confusion and delay.',
                    ],
                ],
            ]);
    }

    public function testAddSuccessful(): void
    {
        $faker = Factory::create();

        $response = $this->post('api/users', [
            'email'  => $faker->email,
            'name'   => $faker->name(),
            'userId' => (string) UserId::generate(),
        ], $this->getHeaders());

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJson([
                'data' => [
                    'added' => true,
                ],
            ]);
    }

    public function testAddInvalidUserIdThrowsException(): void
    {
        $faker = Factory::create();

        $response = $this->post('api/users', [
            'email'  => $faker->email,
            'name'   => $faker->name(),
            'userId' => 'blah',
        ], $this->getHeaders());

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson([
                'errors' => [
                    [
                        'code'   => 400,
                        'title'  => 'Validation Exception',
                        'detail' => 'The user id field must be a valid ULID.',
                    ],
                ],
            ]);
    }

    public function testMissingParamsThrowsException(): void
    {
        $response = $this->post('api/users', [], $this->getHeaders());

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson([
                'errors' => [
                    [
                        'code'   => 400,
                        'detail' => 'The name field is required. (and 2 more errors)',
                        'title'  => 'Validation Exception',
                    ],
                ],
            ]);
    }

    public function testAddInvalidEmailThrowsException(): void
    {
        $faker = Factory::create();

        $response = $this->post('api/users', [
            'email'  => 'not an email',
            'name'   => $faker->name(),
            'userId' => (string) UserId::generate(),
        ], $this->getHeaders());

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson([
                'errors' => [
                    [
                        'code'   => 400,
                        'title'  => 'Validation Exception',
                        'detail' => 'The email must be a valid email address.',
                    ],
                ],
            ]);
    }

    public function testRemoveUnknownUserThrowsException(): void
    {
        $faker = Factory::create();
        $email = $faker->email;

        $response = $this->delete('api/users', [
            'email' => $email,
        ], $this->getHeaders());

        $response->assertStatus(404)
            ->assertJson(['success' => false])
            ->assertJson([
                'errors' => [
                    [
                        'code'   => 404,
                        'title'  => 'User Not Found',
                        'detail' => "User Not Found: '{$email}'",
                    ],
                ],
            ]);
    }

    public function testRemoveInvalidEmailThrowsException(): void
    {
        $response = $this->delete('api/users', [
            'email' => 'not an email',
        ], $this->getHeaders());

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson([
                'errors' => [
                    [
                        'code'   => 400,
                        'detail' => 'The email must be a valid email address.',
                        'title'  => 'Validation Exception',
                    ],
                ],
            ]);
    }

    public function testRemoveNoSignatureThrowsException(): void
    {
        $response = $this->delete('api/users');

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson([
                'errors' => [
                    [
                        'code'   => 400,
                        'title'  => 'Invalid Fat Controller Request',
                        'detail' => 'You have caused confusion and delay.',
                    ],
                ],
            ]);
    }

    public function testCanRemoveUser(): void
    {
        $faker = Factory::create();
        $email = $faker->email;

        $this->post('api/users', [
            'email'  => $email,
            'name'   => $faker->name(),
            'userId' => (string) UserId::generate(),
        ], $this->getHeaders());

        $response = $this->delete('api/users', [
            'email' => $email,
        ], $this->getHeaders());

        $response->assertStatus(200)->assertJson(['success' => true])->assertJson(['data' => ['removed' => true]]);
    }

    public function testCanReinstateUser(): void
    {
        $faker = Factory::create();
        $email = $faker->email;

        $this->post('api/users', [
            'email'  => $email,
            'name'   => $faker->name(),
            'userId' => (string) UserId::generate(),
        ], $this->getHeaders());

        $this->delete('api/users', [
            'email' => $email,
        ], $this->getHeaders());

        $response = $this->post('api/users', [
            'email'  => $email,
            'name'   => $faker->name(),
            'userId' => (string) UserId::generate(),
        ], $this->getHeaders());

        $response->assertStatus(200)->assertJson(['success' => true])->assertJson(['data' => ['added' => true]]);
    }

    private function getHeaders(): array
    {
        $time = time();

        /** @var string $secret */
        $secret = Config::get('services.admin.secret');

        return [
            'X-Timestamp' => $time,
            'X-Signature' => Hash::make("{$secret}{$time}"),
        ];
    }
}
