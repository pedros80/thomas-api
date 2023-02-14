<?php

namespace Tests\Feature\App\Http\Controllers;

use Faker\Factory;
use Faker\Generator as Faker;
use Tests\TestCase;
use Thomas\Users\Domain\Password;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class UsersControllerTest extends TestCase
{
    private Faker $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    public function testRegisterSuccessfull(): void
    {
        $password = Password::generate()->plain();
        $response = $this->post('api/users', [
            'email'                 => $this->faker->email,
            'name'                  => $this->faker->name(),
            'password'              => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function testRegisterMismatchedPasswords(): void
    {
        $password = Password::generate()->plain();
        $response = $this->post('api/users', [
            'email'                 => $this->faker->email,
            'name'                  => $this->faker->name(),
            'password'              => $password,
            'password_confirmation' => 'xxxxxxx',
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'The password confirmation does not match.'
            ]);
    }

    public function testVerifyUnknownUserThrowsException(): void
    {
        $userId      = UserId::generate();
        $verifyToken = VerifyToken::fromUserId($userId);

        $response = $this->get("api/users/{$userId}/verify/{$verifyToken}");
        $response
            ->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => "User Not Found: {$userId}"
            ]);
    }

    public function testVerifyUser(): void
    {
        $password = Password::generate()->plain();
        $response = $this->post('api/users', [
            'email'                 => $this->faker->email,
            'name'                  => $this->faker->name(),
            'password'              => $password,
            'password_confirmation' => $password,
        ]);

        $data = $response->json()['data'];

        $response = $this->get("api/users/{$data['ui']}/verify/{$data['vt']}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'message' => "Verified."
                ]
            ]);
    }
}
