<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\RemoveUserRequest;
use Illuminate\Http\JsonResponse;
use Thomas\Shared\Application\CommandBus;
use Thomas\Users\Application\Commands\AddUser;
use Thomas\Users\Application\Commands\RemoveUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

final class UserController extends Controller
{
    public function add(AddUserRequest $request, CommandBus $commandBus): JsonResponse
    {
        $command = new AddUser(
            new Email($request->email),
            new Name($request->name),
            new UserId($request->userId),
        );

        $commandBus->dispatch($command);

        return new JsonResponse([
            'success' => true,
            'data'    => 'Added.',
        ]);
    }

    public function remove(RemoveUserRequest $request, CommandBus $commandBus): JsonResponse
    {
        $command = new RemoveUser(
            new Email($request->email)
        );

        $commandBus->dispatch($command);

        return new JsonResponse([
            'success' => true,
            'data'    => 'Removed.',
        ]);
    }
}
