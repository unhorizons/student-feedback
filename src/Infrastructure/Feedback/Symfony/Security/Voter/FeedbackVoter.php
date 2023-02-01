<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Symfony\Security\Voter;

use Domain\Feedback\Entity\Feedback;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class ReportVoter.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class FeedbackVoter extends Voter
{
    public const ATTRIBUTES = [
        'FEEDBACK_VIEW',
        'FEEDBACK_DELETE',
        'FEEDBACK_UPDATE',
    ];

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (in_array($attribute, self::ATTRIBUTES, true)) {
            return false;
        }

        if (! $subject instanceof Feedback) {
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
        if (null === $user) {
            return false;
        }

        return match ($attribute) {
            'FEEDBACK_VIEW' => $user === $subject->getOwner(),
            'FEEDBACK_DELETE', 'FEEDBACK_EDIT' => false === $subject->isIsRead(),
            default => true
        };
    }
}
