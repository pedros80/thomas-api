<?php

namespace Tests\Feature\App\Http\Controllers;

use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Thomas\Users\Domain\UserId;

final class UserControllerTest extends TestCase
{
    public function testNoSignatureThrowsException(): void
    {
        $response = $this->post('api/users');

        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJson(['errors' => 'You have caused confusion and delay.']);
    }

    public function testAddSuccessful(): void
    {
        $faker = Factory::create();

        $response = $this->post('api/users', [
            'email'  => $faker->email,
            'name'   => $faker->name(),
            'userId' => (string) UserId::generate(),
        ], $this->getHeaders());

        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function testAddInvalidUserIdThrowsException(): void
    {
        $faker = Factory::create();

        $response = $this->post('api/users', [
            'email'  => $faker->email,
            'name'   => $faker->name(),
            'userId' => 'blah',
        ], $this->getHeaders());

        $response->assertStatus(400)->assertJson(['success' => false, 'errors' => 'The user id field must be a valid ULID.']);
    }

    public function testMissingParamsThrowsException(): void
    {
        $response = $this->post('api/users', [], $this->getHeaders());

        $response->assertStatus(400)->assertJson(['success' => false, 'errors' => 'The name field is required. (and 2 more errors)']);
    }

    public function testAddInvalidEmailThrowsException(): void
    {
        $faker = Factory::create();

        $response = $this->post('api/users', [
            'email'  => 'not an email',
            'name'   => $faker->name(),
            'userId' => (string) UserId::generate(),
        ], $this->getHeaders());

        $response->assertStatus(400)->assertJson(['success' => false, 'errors' => 'The email must be a valid email address.']);
    }

    private function getHeaders(): array
    {
        $time   = time();
        $secret = config('services.admin.secret');

        return [
            'X-Timestamp' => $time,
            'X-Signature' => Hash::make("{$secret}{$time}"),
        ];
    }
}
