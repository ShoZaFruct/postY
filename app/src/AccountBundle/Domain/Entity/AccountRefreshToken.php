<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'account_refresh_token')]
class AccountRefreshToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private $id;

    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'refresh_tokens')]
    #[ORM\JoinTable()]
    private Account $account;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getExpiresAt(): \DateTimeInterface
    {
        return $this->expiresAt;
    }
}