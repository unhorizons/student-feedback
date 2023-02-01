<?php

declare(strict_types=1);

namespace Application\Feedback\Command;

use Application\Shared\Mapper;
use Domain\Feedback\Entity\FeedbackResponse;

/**
 * class UpdateFeedbackResponseCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateFeedbackResponseCommand
{
    public function __construct(
        public readonly FeedbackResponse $state,
        public ?string $content = null
    ) {
        Mapper::hydrate($this->state, $this);
    }
}
