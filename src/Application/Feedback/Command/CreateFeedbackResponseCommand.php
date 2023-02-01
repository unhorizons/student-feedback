<?php

declare(strict_types=1);

namespace Application\Feedback\Command;

use Domain\Authentication\Entity\User;
use Domain\Feedback\Entity\Feedback;

/**
 * class CreateFeedbackResponseCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateFeedbackResponseCommand
{
    public function __construct(
        public readonly User $owner,
        public readonly Feedback $feedback,
        public ?string $content = null
    ) {
    }
}
