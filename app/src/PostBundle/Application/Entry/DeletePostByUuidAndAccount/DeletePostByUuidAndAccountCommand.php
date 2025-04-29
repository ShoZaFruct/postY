<?php

declare(strict_types=1);

namespace App\PostBundle\Application\Entry\DeletePostByUuidAndAccount;

use App\AccountBundle\Domain\Entity\Account;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(
    title: self::class,
    properties: [
        new OA\Property(property: 'uuid', description: 'Uuid поста', type: 'string', nullable: false),
    ]
)]
readonly class DeletePostByUuidAndAccountCommand
{
    #[Assert\NotNull()]
    #[Assert\Type(type: Account::class)]
    public Account $account;

    #[Assert\NotNull()]
    #[Assert\Type('string')]
    public string $uuid;

    public function __construct(
        Account $account,
        string $uuid,
    ) {
        $this->account = $account;
        $this->uuid = $uuid;
    }
}