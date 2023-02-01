<?php

declare(strict_types=1);

namespace Domain\Feedback\Event;

use Domain\Feedback\Entity\Feedback;

/**
 * class FeedbackViewedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class FeedbackViewedEvent
{
    public function __construct(
        public readonly Feedback $feedback
    ) {
    }
}
