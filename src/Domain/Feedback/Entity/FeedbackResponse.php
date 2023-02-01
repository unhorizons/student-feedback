<?php

declare(strict_types=1);

namespace Domain\Feedback\Entity;

use Domain\Shared\Entity\AbstractEntity;
use Domain\Shared\Entity\OwnerTrait;

/**
 * class FeedbackResponse.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class FeedbackResponse extends AbstractEntity
{
    use OwnerTrait;

    public ?Feedback $feedback = null;

    public ?string $content = null;

    public function getFeedback(): ?Feedback
    {
        return $this->feedback;
    }

    public function setFeedback(?Feedback $feedback): self
    {
        $this->feedback = $feedback;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
