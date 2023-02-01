<?php

declare(strict_types=1);

namespace Application\Feedback\Handler;

use Application\Feedback\Command\UpdateFeedbackCommand;
use Application\Shared\Mapper;
use Domain\Feedback\Exception\CannotMutateReadFeedbackException;
use Domain\Feedback\Repository\FeedbackRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateFeedbackHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateFeedbackHandler
{
    public function __construct(
        private readonly FeedbackRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateFeedbackCommand $command): void
    {
        if ($command->state->isIsRead()) {
            throw new CannotMutateReadFeedbackException();
        }

        $this->repository->save(Mapper::getHydratedObject($command, $command->state));
    }
}
