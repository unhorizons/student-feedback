<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\EventSubscriber;

use Domain\Authentication\Event\LoginLinkRequestedEvent;
use Infrastructure\Shared\Symfony\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * class AuthenticationEventSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class AuthenticationEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly Mailer $mailer,
    ) {
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            LoginLinkRequestedEvent::class => 'onLoginLinkRequested',
        ];
    }

    public function onLoginLinkRequested(LoginLinkRequestedEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/authentication/mail/login_link.mail.twig',
            subject: 'authentication.mails.subjects.login_link_requested',
            domain: 'authentication'
        );
    }
}
