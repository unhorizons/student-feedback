<?php

declare(strict_types=1);

namespace Application\Feedback\Handler;

use Application\Feedback\Command\SetFeedbackViewedCommand;
use Domain\Feedback\Repository\FeedbackRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class SetFeedbackViewedHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class SetFeedbackViewedHandler
{
    public function __construct(
        private readonly FeedbackRepositoryInterface $repository
    ) {
    }

    public function __invoke(SetFeedbackViewedCommand $command): void
    {
        $this->repository->save($command->feedback->setIsRead(true));
    }
}
