<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\RemoveUserRequest;
use Thomas\Shared\Application\CommandBus;
use Thomas\Shared\Framework\SuccessResponse;
use Thomas\Users\Application\Commands\AddUser;
use Thomas\Users\Application\Commands\RemoveUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\RemovedAt;

final class UserController extends Controller
{
    public function add(AddUserRequest $request, CommandBus $commandBus): SuccessResponse
    {
        $commandBus->dispatch(
            AddUser::fromArray($request->validated())
        );

        return new SuccessResponse(['added' => true]);
    }

    public function remove(RemoveUserRequest $request, CommandBus $commandBus): SuccessResponse
    {
        $data = $request->validated();

        /** @var string $email */
        $email = $data['email'];

        $command = new RemoveUser(
            new Email($email),
            RemovedAt::now()
        );

        $commandBus->dispatch($command);

        return new SuccessResponse(['removed' => true]);
    }
}
