<?php

declare(strict_types=1);

namespace Domain\Feedback\Repository;

use Domain\Authentication\Entity\User;
use Domain\Shared\Repository\DataRepositoryInterface;

/**
 * Interface FeedbackRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface FeedbackRepositoryInterface extends DataRepositoryInterface
{
    public function findStats(): array;

    public function findCurrentYearFrequency(): array;

    public function monthlyFeedbackLimitReached(User $owner, int $limit = 1): bool;
}
