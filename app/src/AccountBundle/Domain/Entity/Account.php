<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'account')]
class Account implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?string $uuid;

    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: false)]
    private string $username;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $password;

    #[ORM\OneToMany(targetEntity: AccountRefreshToken::class, mappedBy: 'account', cascade: ['persist', 'remove'])]
    private Collection $refreshTokens;

    public function __construct(
        string $username,
    ) {
        $this->username = $username;
        $this->refreshTokens = new ArrayCollection();
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getRefreshTokens(): Collection
    {
        return $this->refreshTokens;
    }

    public function setRefreshTokens(Collection $refreshTokens): void
    {
        $this->refreshTokens = $refreshTokens;
    }

    public function addRefreshToken(AccountRefreshToken $refreshToken): void
    {
        $this->refreshTokens->add($refreshToken);
    }

    public function eraseCredentials(): void
    {
    }
}
