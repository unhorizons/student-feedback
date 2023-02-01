<?php

declare(strict_types=1);

namespace Application\Feedback\Handler;

use Application\Feedback\Command\DeleteFeedbackCommand;
use Domain\Feedback\Exception\CannotMutateReadFeedbackException;
use Domain\Feedback\Repository\FeedbackRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteFeedbackHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeleteFeedbackHandler
{
    public function __construct(
        private readonly FeedbackRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeleteFeedbackCommand $command): void
    {
        if (true === $command->entity->isIsRead()) {
            throw new CannotMutateReadFeedbackException();
        }

        $this->repository->delete($command->entity);
    }
}
