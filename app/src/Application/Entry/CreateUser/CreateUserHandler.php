<?php

declare(strict_types=1);

namespace App\Application\Entry\CreateUser;

use App\Domain\DTO\Request\CreateUserRequest;
use App\Domain\Service\UserService;

readonly class CreateUserHandler
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    public function __invoke(CreateUserCommand $command): string
    {
        return $this->userService->createUser(new CreateUserRequest(
            username: $command->username,
            password: $command->password,
        ));
    }
}