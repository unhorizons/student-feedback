<?php

declare(strict_types=1);

namespace Application\Feedback\Command;

use Domain\Feedback\Entity\Feedback;

/**
 * class SetFeedbackViewedCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class SetFeedbackViewedCommand
{
    public function __construct(
        public readonly Feedback $feedback
    ) {
    }
}
