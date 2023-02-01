<?php

declare(strict_types=1);

namespace Application\Feedback\Handler;

use Application\Feedback\Command\CreateFeedbackCommand;
use Application\Shared\Mapper;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Exception\MonthlyFeedbackLimitReachedException;
use Domain\Feedback\Repository\FeedbackRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateFeedbackCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateFeedbackHandler
{
    private const MONTHLY_LIMIT = 1;

    public function __construct(
        private readonly FeedbackRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateFeedbackCommand $command): void
    {
        if ($this->repository->monthlyFeedbackLimitReached($command->owner, self::MONTHLY_LIMIT)) {
            throw new MonthlyFeedbackLimitReachedException();
        }

        $feedback = Mapper::getHydratedObject($command, new Feedback());
        $this->repository->save($feedback);
    }
}
