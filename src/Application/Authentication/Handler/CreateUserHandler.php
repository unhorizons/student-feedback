<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\CreateUserCommand;
use Application\Shared\Mapper;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Exception\EmailAlreadyUsedException;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateUserHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        /** @var User|null $user */
        $user = $this->repository->findOneBy([
            'email' => $command->email,
        ]);

        if (null !== $user) {
            throw new EmailAlreadyUsedException();
        }

        $this->repository->save(Mapper::getHydratedObject($command, new User()));
    }
}
