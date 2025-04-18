<?php

declare(strict_types=1);

namespace App\Domain\DTO\Request;

readonly class CreateUserRequest
{
    public function __construct(
        public string $username,
        public string $password,
    ) {
    }
}