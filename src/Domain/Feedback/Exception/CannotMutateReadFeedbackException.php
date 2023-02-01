<?php

declare(strict_types=1);

namespace Domain\Feedback\Exception;

use Domain\Shared\Exception\SafeMessageException;

/**
 * class CannotDeleteReadFeedbackException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CannotMutateReadFeedbackException extends SafeMessageException
{
    protected string $messageDomain = 'feedback';

    public function __construct(
        string $message = 'feedback.exceptions.cannot_mutate_read_feedback',
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
