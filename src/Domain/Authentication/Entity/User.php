<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Domain\Authentication\ValueObject\Roles;
use Domain\Shared\Entity\AbstractEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * class User.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class User extends AbstractEntity implements UserInterface
{
    private ?string $email = null;

    private Roles $roles;

    public function __construct()
    {
        $this->roles = Roles::student();
    }

    public function getRoles(): array
    {
        return $this->roles->toArray();
    }

    public function setRoles(Roles|array $roles): self
    {
        if (is_array($roles)) {
            $this->roles = Roles::fromArray($roles);
        } else {
            $this->roles = $roles;
        }

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
