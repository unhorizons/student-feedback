<?php

declare(strict_types=1);

namespace Domain\Feedback\Event;

use Domain\Authentication\Entity\User;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Entity\FeedbackResponse;

/**
 * class FeedbackRespondedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class FeedbackRespondedEvent
{
    public User $user;

    public function __construct(
        public readonly Feedback $feedback,
        public readonly FeedbackResponse $response
    ) {
        /** @var User $user */
        $user = $this->feedback->getOwner();
        $this->user = $user;
    }
}
