<?php

declare(strict_types=1);

namespace Domain\Authentication\ValueObject;

use Webmozart\Assert\Assert;

/**
 * Class Role.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Roles implements \Stringable
{
    public const VALUES = ['ROLE_ADMIN', 'ROLE_USER', 'ROLE_SUPER_ADMIN'];
    public const CHOICES = [
        'authentication.value_object.roles.admin' => 'ROLE_ADMIN',
        'authentication.value_object.roles.student' => 'ROLE_USER',
    ];

    private readonly array $roles;

    private function __construct(array $roles = ['ROLE_USER'])
    {
        Assert::notEmpty($roles, 'authentication.validations.empty_roles');
        foreach ($roles as $role) {
            Assert::inArray($role, self::VALUES, 'authentication.validations.invalid_roles');
        }

        $roles[] = 'ROLE_USER';
        $this->roles = array_unique($roles);
    }

    public function __toString(): string
    {
        return implode(',', $this->roles);
    }

    public function getTranslationKey(): string
    {
        return match (true) {
            $this->contains('ROLE_ADMIN') => 'authentication.value_object.roles.admin',
            $this->contains('ROLE_USER') => 'authentication.value_object.roles.student',
            default => 'authentication.value_object.roles.user'
        };
    }

    public function toArray(): array
    {
        return $this->roles;
    }

    public static function fromArray(array $roles): self
    {
        return new self($roles);
    }

    public static function superAdmin(): self
    {
        return new self(['ROLE_SUPER_ADMIN']);
    }

    public static function admin(): self
    {
        return new self(['ROLE_ADMIN']);
    }

    public static function student(): self
    {
        return new self(['ROLE_USER']);
    }

    public function equals(array|self $roles): bool
    {
        if ($roles instanceof self) {
            return $roles->roles === $this->roles;
        }

        return $roles === $this->roles;
    }

    public function contains(string $role): bool
    {
        return in_array($role, $this->roles, true);
    }
}
