<?php

namespace Tests\Feature\App\Http\Controllers;

use Faker\Factory;
use Tests\TestCase;
use Thomas\Users\Domain\UserId;

final class UsersControllerTest extends TestCase
{
    public function testAddSuccessful(): void
    {
        $faker = Factory::create();

        $response = $this->post('api/users', [
            'email'  => $faker->email,
            'name'   => $faker->name(),
            'userId' => (string) UserId::generate(),
        ]);

        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function testAddInvalidUserIdThrowsException(): void
    {
        $faker = Factory::create();

        $response = $this->post('api/users', [
            'email'  => $faker->email,
            'name'   => $faker->name(),
            'userId' => 'blah',
        ]);

        $response->assertStatus(400)->assertJson(['success' => false, 'message' => 'The user id field must be a valid ULID.']);
    }

    public function testAddInvalidEmailThrowsException(): void
    {
        $faker = Factory::create();

        $response = $this->post('api/users', [
            'email'  => 'not an email',
            'name'   => $faker->name(),
            'userId' => (string) UserId::generate(),
        ]);

        $response->assertStatus(400)->assertJson(['success' => false, 'message' => 'The email must be a valid email address.']);
    }
}
