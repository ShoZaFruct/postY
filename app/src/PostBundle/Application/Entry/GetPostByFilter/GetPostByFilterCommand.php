<?php

declare(strict_types=1);

namespace App\PostBundle\Application\Entry\GetPostByFilter;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(
    title: self::class,
    properties: [
        new OA\Property(property: 'username', description: 'Имя пользователя', type: 'string', nullable: true),
        new OA\Property(property: 'createdAt', description: 'Дата создания поста', type: 'string', nullable: true),
        new OA\Property(property: 'page', description: 'Номер страницы', type: 'integer', nullable: true),
        new OA\Property(property: 'limit', description: 'Лимит items на странице', type: 'integer', nullable: true),
    ]
)]
readonly class GetPostByFilterCommand
{
    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    public ?string $username;

    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    public ?string $createdAt;

    #[Assert\Type('integer')]
    public ?int $page;

    #[Assert\Type('integer')]
    public ?int $limit;

    public function __construct(
        ?string $username,
        ?string $createdAt,
        ?int $page,
        ?int $limit,
    ) {
        $this->username = $username;
        $this->createdAt = $createdAt;
        $this->page = $page;
        $this->limit = $limit;
    }
}