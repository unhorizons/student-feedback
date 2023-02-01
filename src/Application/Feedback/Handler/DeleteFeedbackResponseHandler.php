<?php

declare(strict_types=1);

namespace Application\Feedback\Handler;

use Application\Feedback\Command\DeleteFeedbackResponseCommand;
use Domain\Feedback\Repository\FeedbackRepositoryInterface;
use Infrastructure\Feedback\Doctrine\Repository\FeedbackResponseRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteFeedbackResponseHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeleteFeedbackResponseHandler
{
    public function __construct(
        private readonly FeedbackResponseRepository $repository,
        private readonly FeedbackRepositoryInterface $feedbackRepository
    ) {
    }

    public function __invoke(DeleteFeedbackResponseCommand $command): void
    {
        $feedback = $command->entity->getFeedback();
        if (null !== $feedback) {
            $feedback->decreaseResponseCount();
            $this->feedbackRepository->save($feedback);
        }

        $this->repository->delete($command->entity);
    }
}
