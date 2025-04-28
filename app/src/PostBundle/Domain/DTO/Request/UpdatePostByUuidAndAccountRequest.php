<?php

declare(strict_types=1);

namespace App\PostBundle\Domain\DTO\Request;

use App\AccountBundle\Domain\Entity\Account;

readonly class UpdatePostByUuidAndAccountRequest
{
    public function __construct(
        private Account $account,
        private string $uuid,
        private ?string $title,
        private ?string $content,
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
}