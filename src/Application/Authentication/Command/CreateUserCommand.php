<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\ValueObject\Roles;

/**
 * class CreateUserCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateUserCommand
{
    public function __construct(
        public ?string $email,
        public Roles $roles,
    ) {
        $this->roles = Roles::student();
    }
}
