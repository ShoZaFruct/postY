<?php

declare(strict_types=1);

namespace App\PostBundle\Application\Entry\CreatePost;

use App\AccountBundle\Domain\Entity\Account;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(
    title: self::class,
    properties: [
        new OA\Property(property: 'title', description: 'Заголовок поста', type: 'string', nullable: false),
        new OA\Property(property: 'content', description: 'Контент поста', type: 'string', nullable: false),
    ]
)]
readonly class CreatePostCommand
{
    #[Assert\NotNull()]
    #[Assert\Type(type: Account::class)]
    public Account $account;

    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Assert\Length(min: 1, max: 255)]
    public string $title;

    public string $content;

    public function __construct(
        Account $account,
        string $title,
        string $content,
    ) {
        $this->account = $account;
        $this->title = $title;
        $this->content = $content;
    }
}