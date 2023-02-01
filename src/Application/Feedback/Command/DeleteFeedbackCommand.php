<?php

declare(strict_types=1);

namespace Application\Feedback\Command;

use Domain\Feedback\Entity\Feedback;

/**
 * class DeleteFeedbackCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeleteFeedbackCommand
{
    public function __construct(
        public readonly Feedback $entity
    ) {
    }
}
