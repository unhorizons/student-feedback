<?php

declare(strict_types=1);

namespace Application\Feedback\Handler;

use Application\Feedback\Command\CreateFeedbackResponseCommand;
use Application\Shared\Mapper;
use Domain\Feedback\Entity\FeedbackResponse;
use Domain\Feedback\Event\FeedbackRespondedEvent;
use Domain\Feedback\Repository\FeedbackRepositoryInterface;
use Infrastructure\Feedback\Doctrine\Repository\FeedbackRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateFeedbackResponseHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateFeedbackResponseHandler
{
    public function __construct(
        private readonly FeedbackRepositoryInterface $repository,
        private readonly FeedbackRepository $feedbackRepository,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(CreateFeedbackResponseCommand $command): void
    {
        /** @var FeedbackResponse $entity */
        $entity = Mapper::getHydratedObject($command, new FeedbackResponse());
        $this->repository->save($entity);

        $command->feedback->increaseResponseCount();
        $this->feedbackRepository->save($command->feedback);

        $this->dispatcher->dispatch(new FeedbackRespondedEvent(
            feedback: $command->feedback,
            response: $entity
        ));
    }
}
