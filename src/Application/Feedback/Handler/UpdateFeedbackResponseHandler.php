<?php

declare(strict_types=1);

namespace Application\Feedback\Handler;

use Application\Feedback\Command\UpdateFeedbackResponseCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateFeedbackResponseCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateFeedbackResponseHandler
{
    public function __invoke(UpdateFeedbackResponseCommand $command): void
    {
    }
}
