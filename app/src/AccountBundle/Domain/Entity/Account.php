<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'account')]
class Account implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }

    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getRefreshTokens(): Collection
    {
        return $this->refreshTokens;
    }

    /**
     * @param Collection $refreshTokens
     * @return void
     */
    public function setRefreshTokens(Collection $refreshTokens): void
    {
        $this->refreshTokens = $refreshTokens;
    }

    /**
     * @param AccountRefreshToken $refreshToken
     * @return void
     */
    public function addRefreshToken(AccountRefreshToken $refreshToken): void
    {
        $this->refreshTokens->add($refreshToken);
    }

    /**
     * @return void
     */
    public function eraseCredentials(): void
    {
    }
}
