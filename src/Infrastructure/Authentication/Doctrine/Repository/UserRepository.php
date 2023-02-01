<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class UserRepository.
 *
 * @extends AbstractRepository<User>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
}
