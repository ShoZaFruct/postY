<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity]
#[ORM\Table(name: 'account_refresh_token')]
class AccountRefreshToken
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?string $uuid;

    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'refresh_tokens')]
    #[ORM\JoinColumn(name: 'account_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Account $account;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $refreshToken;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $expiresAt;

    public function __construct(
        Account $account,
        string $refreshToken,
        \DateTimeInterface $expiresAt,
    ) {
        $this->account = $account;
        $this->refreshToken = $refreshToken;
        $this->expiresAt = $expiresAt;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getExpiresAt(): \DateTimeInterface
    {
        return $this->expiresAt;
    }
}