<?php

declare(strict_types=1);

namespace Application\Feedback\Command;

use Domain\Feedback\Entity\FeedbackResponse;

/**
 * class DeleteFeedbackResponseCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeleteFeedbackResponseCommand
{
    public function __construct(
        public readonly FeedbackResponse $entity
    ) {
    }
}
