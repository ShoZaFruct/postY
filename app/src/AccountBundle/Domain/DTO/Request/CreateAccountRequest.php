<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\DTO\Request;

readonly class CreateAccountRequest
{
    public function __construct(
        public string $username,
        public string $password,
    ) {
    }
}