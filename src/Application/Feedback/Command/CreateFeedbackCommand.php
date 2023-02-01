<?php

declare(strict_types=1);

namespace Application\Feedback\Command;

use Domain\Authentication\Entity\User;

/**
 * class CreateFeedbackCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateFeedbackCommand
{
    public function __construct(
        public readonly User $owner,
        public ?string $content = null,
        public ?string $promotion = null,
        public bool $is_anonymous = false
    ) {
    }
}
