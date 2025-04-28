<?php

declare(strict_types=1);

namespace App\PostBundle\Application\DTO\Response;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: self::class,
    properties: [
        new OA\Property(property: 'uuid', type: 'string', nullable: false),
        new OA\Property(property: 'title', type: 'string', nullable: false),
        new OA\Property(property: 'content', type: 'string', nullable: false),
        new OA\Property(property: 'createdAt', type: 'string', nullable: false),
    ]
)]
readonly class CreatePostResponse implements \JsonSerializable
{
    public function __construct(
        private string $uuid,
        private string $title,
        private string $content,
        private \DateTimeInterface $createdAt,
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

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'title' => $this->getTitle(),
            'content' => $this->getContent(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}