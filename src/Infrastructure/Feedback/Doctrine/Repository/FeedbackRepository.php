<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Doctrine\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\User;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Repository\FeedbackRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class FeedbackRepository.
 *
 * @extends AbstractRepository<Feedback>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class FeedbackRepository extends AbstractRepository implements FeedbackRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feedback::class);
    }

    public function monthlyFeedbackLimitReached(User $owner, int $limit = 1): bool
    {
        $start = new \DateTimeImmutable('first day of this month');
        $end = new \DateTimeImmutable('last day of this month');

        try {
            $count = $this->createQueryBuilder('f')
                ->select('COUNT(f.id)')
                ->where('f.owner = :owner')
                ->andWhere('f.created_at BETWEEN :start AND :end')
                ->setParameter('owner', $owner)
                ->setParameter('start', $start->format('Y-m-d'))
                ->setParameter('end', $end->format('Y-m-d'))
                ->getQuery()
                ->getSingleScalarResult();

            return $count > $limit;
        } catch (NoResultException) {
            return false;
        } catch (NonUniqueResultException) {
            return true;
        }
    }
}
