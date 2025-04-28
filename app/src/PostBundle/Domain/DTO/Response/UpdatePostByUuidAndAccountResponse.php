<?php

declare(strict_types=1);

namespace App\PostBundle\Domain\DTO\Response;

readonly class UpdatePostByUuidAndAccountResponse
{
    public function __construct(
        private string $uuid,
        private string $title,
        private string $content,
        private \DateTimeInterface $createdAt,
        private \DateTimeInterface $updatedAt,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
}