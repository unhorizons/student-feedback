<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Symfony\EventSubscriber;

use Application\Feedback\Command\SetFeedbackViewedCommand;
use Domain\Feedback\Event\FeedbackRespondedEvent;
use Domain\Feedback\Event\FeedbackViewedEvent;
use Infrastructure\Shared\Symfony\Mailer\Mailer;
use Infrastructure\Shared\Symfony\Messenger\DispatchTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * class FeedbackEventSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class FeedbackEventSubscriber implements EventSubscriberInterface
{
    use DispatchTrait;

    public function __construct(
        protected readonly MessageBusInterface $commandBus,
        protected readonly LoggerInterface $logger,
        private readonly Mailer $mailer
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FeedbackViewedEvent::class => 'onFeedbackViewed',
            FeedbackRespondedEvent::class => 'onFeedbackResponded',
        ];
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function onFeedbackResponded(FeedbackRespondedEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            event: $event,
            template: '@app/domain/feedback/mail/feedback_responded.mail.twig',
            subject: 'feedback.mails.subjects.feedback_responded',
            domain: 'feedback'
        );
    }

    public function onFeedbackViewed(FeedbackViewedEvent $event): void
    {
        try {
            $this->dispatchSync(new SetFeedbackViewedCommand($event->feedback));
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
        }
    }
}
