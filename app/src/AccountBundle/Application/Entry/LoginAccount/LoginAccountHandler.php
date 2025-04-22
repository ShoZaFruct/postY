<?php

declare(strict_types=1);

namespace App\AccountBundle\Application\Entry\LoginAccount;

use App\AccountBundle\Domain\DTO\Request\LoginAccountRequest;
use App\AccountBundle\Domain\Service\AuthService;

readonly class LoginAccountHandler
{
    public function __construct(
        private AuthService $authService,
    ) {
    }

    public function __invoke(LoginAccountCommand $command): array
    {
        return $this->authService->loginAccount(
            new LoginAccountRequest(
                username: $command->username,
                password: $command->password,
            )
        );
    }
}