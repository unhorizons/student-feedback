<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Feedback\Entity\FeedbackResponse;
use Domain\Feedback\Repository\FeedbackResponseRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class FeedbackResponseRepository.
 *
 * @extends AbstractRepository<FeedbackResponse>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class FeedbackResponseRepository extends AbstractRepository implements FeedbackResponseRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeedbackResponse::class);
    }
}
