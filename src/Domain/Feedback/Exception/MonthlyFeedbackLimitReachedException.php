<?php

declare(strict_types=1);

namespace Domain\Feedback\Exception;

use Domain\Shared\Exception\SafeMessageException;

/**
 * class CannotSubmitMoreThanOneFeedbackPerMonthException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class MonthlyFeedbackLimitReachedException extends SafeMessageException
{
    protected string $messageDomain = 'feedback';

    public function __construct(
        string $message = 'feedback.exceptions.monthly_feedback_limit_reached',
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
