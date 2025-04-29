<?php

declare(strict_types=1);

namespace App\PostBundle\Domain\DTO\Request;

use App\AccountBundle\Domain\Entity\Account;

readonly class DeletePostByUuidAndAccountRequest
{
    public function __construct(
        private Account $account,
        private string $uuid,
    ) {
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}