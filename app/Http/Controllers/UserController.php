<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\JsonResponse;
use Thomas\Shared\Application\CommandBus;
use Thomas\Users\Application\Commands\RegisterUser;
use Thomas\Users\Application\Commands\VerifyUser;
use Thomas\Users\Application\Queries\GetEmailFromUserIdAndVerifyToken;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\Password;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class UserController extends Controller
{
    public function register(RegisterUserRequest $request, CommandBus $commandBus): JsonResponse
    {
        $userId      = UserId::generate();
        $verifyToken = VerifyToken::fromUserId($userId);

        $command = new RegisterUser(
            new Email($request->email),
            new Name($request->name),
            new Password($request->password),
            $userId,
            $verifyToken
        );

        $commandBus->dispatch($command);

        return new JsonResponse([
            'success' => true,
            'data'    => [
                'message' => 'Registered, please check you emails',
                'vt'      => (string) $verifyToken,
                'ui'      => (string) $userId,
            ],
        ]);
    }

    public function verify(
        string $userId,
        string $verifyToken,
        GetEmailFromUserIdAndVerifyToken $query,
        CommandBus $commandBus
    ): JsonResponse {
        $userId      = new UserId($userId);
        $verifyToken = new VerifyToken($verifyToken);

        $email = $query->get($userId, $verifyToken);

        $commandBus->dispatch(new VerifyUser($email, $verifyToken));

        return new JsonResponse([
            'success' => true,
            'data'    => [
                'message' => 'Verified.',
                'email'   => (string) $email,
            ]
        ]);
    }
}
