<?php

declare(strict_types=1);

namespace App\Application\Entry\CreateUser;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: self::class,
    properties: [
        new OA\Property(property: 'username', description: 'Уникальное имя пользователя', type: 'string', nullable: false),
        new OA\Property(property: 'password', description: 'Пароль пользователя', type: 'string', nullable: false),
    ]
)]
readonly class CreateUserCommand
{
    public function __construct(
        public string $username,
        public string $password,
    ) {
    }
}