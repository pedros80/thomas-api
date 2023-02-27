<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Thomas\Users\Domain\UsersRepository;
use Thomas\Users\Infrastructure\UserResolver;

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
            /** @var UserResolver $resolver */
            $resolver = app(UserResolver::class);

            return $resolver->resolve($request->bearerToken());
        });
    }
}
