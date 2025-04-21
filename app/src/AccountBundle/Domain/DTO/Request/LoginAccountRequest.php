<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\DTO\Request;

readonly class LoginAccountRequest
{
    public function __construct(
        public string $username,
        public string $password,
    ) {
    }
}