<?php

declare(strict_types=1);

namespace App\AccountBundle\Application\Entry\LoginAccount;

readonly class LoginAccountCommand
{
    public function __construct(
        public string $username,
        public string $password,
    ) {
    }
}