<?php

declare(strict_types=1);

namespace App\PostBundle\Application\Entry\UpdatePostByUuidAndAccount;

use App\AccountBundle\Domain\Entity\Account;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(
    title: self::class,
    properties: [
        new OA\Property(property: 'uuid', description: 'Uuid поста', type: 'string', nullable: false),
        new OA\Property(property: 'title', description: 'Заголовок поста', type: 'string', nullable: true),
        new OA\Property(property: 'content', description: 'Контент поста', type: 'string', nullable: true),
    ]
)]
readonly class UpdatePostByUuidAndAccountCommand
{
    #[Assert\NotNull()]
    #[Assert\Type(type: Account::class)]
    public Account $account;

    #[Assert\NotNull()]
    #[Assert\Type('string')]
    public string $uuid;

    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    public ?string $title;

    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    public ?string $content;

    public function __construct(
        Account $account,
        string $uuid,
        ?string $title,
        ?string $content,
    ) {
        $this->account = $account;
        $this->uuid = $uuid;
        $this->title = $title;
        $this->content = $content;
    }
}