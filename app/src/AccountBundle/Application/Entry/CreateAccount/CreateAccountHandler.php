<?php

declare(strict_types=1);

namespace App\AccountBundle\Application\Entry\CreateAccount;

use App\AccountBundle\Domain\DTO\Request\CreateAccountRequest;
use App\AccountBundle\Domain\Service\AccountService;

readonly class CreateAccountHandler
{
    public function __construct(
        private AccountService $accountService,
    ) {
    }

    public function __invoke(CreateAccountCommand $command): string
    {
        return $this->accountService->createAccount(new CreateAccountRequest(
            username: $command->username,
            password: $command->password,
        ));
    }
}