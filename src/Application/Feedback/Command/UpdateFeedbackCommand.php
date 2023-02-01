<?php

declare(strict_types=1);

namespace Application\Feedback\Command;

use Application\Shared\Mapper;
use Domain\Feedback\Entity\Feedback;

/**
 * class UpdateFeedbackCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateFeedbackCommand
{
    public function __construct(
        public readonly Feedback $state,
        public ?string $content = null,
        public ?string $promotion = null,
        public bool $is_anonymous = false
    ) {
        Mapper::hydrate($this->state, $this);
    }
}
