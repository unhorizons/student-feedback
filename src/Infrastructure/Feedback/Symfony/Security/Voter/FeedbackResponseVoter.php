<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Symfony\Security\Voter;

use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Entity\FeedbackResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * class FeedbackResponseVoter.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class FeedbackResponseVoter extends Voter
{
    public const ATTRIBUTES = [
        'FEEDBACK_RESPONSE_DELETE',
        'FEEDBACK_RESPONSE_UPDATE',
    ];

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (in_array($attribute, self::ATTRIBUTES, true)) {
            return false;
        }

        if (! $subject instanceof FeedbackResponse) {
            return false;
        }

        return true;
    }

    /**
     * @param Feedback $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        dump($user, $subject);
        if (null === $user) {
            return false;
        }

        if ($user !== $subject->getOwner()) {
            return false;
        }

        return true;
    }
}
