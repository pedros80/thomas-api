<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Thomas\Shared\Infrastructure\Exceptions\EventStreamNotFound;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Exceptions\InvalidJWT;
use Thomas\Users\Domain\Exceptions\UserNotFound;
use Thomas\Users\Domain\UsersRepository;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('custom', function ($app, array $config) {
            return new CustomUserProvider($app->make(UsersRepository::class));
        });

        Auth::viaRequest('jwt', function (Request $request) {
            /** @var UsersRepository $repo */
            $repo  = app(UsersRepository::class);
            /** @var string $jwt */
            $jwt   = $request->bearerToken();

            if (!$jwt) {
                throw InvalidJWT::create();
            }

            $token = JWT::decode($jwt, new Key(config('jwt.secret'), config('jwt.algo')));
            $email = new Email($token->email);

            if (isset($token->exp) && $token->exp > time()) {
                throw UserNotFound::fromEmail($email);
            }

            try {
                $user = $repo->find($email);

                return $user;
            } catch (EventStreamNotFound | UserNotFound) {
                throw UserNotFound::fromEmail($email);
            }
        });
    }
}
