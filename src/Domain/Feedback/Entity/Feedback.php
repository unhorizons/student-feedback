<?php

declare(strict_types=1);

namespace Domain\Feedback\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Shared\Entity\AbstractEntity;
use Domain\Shared\Entity\OwnerTrait;

/**
 * class Feedback.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Feedback extends AbstractEntity
{
    use OwnerTrait;

    private ?string $content = null;

    private ?string $status = null;

    private bool $is_read = false;

    private bool $is_anonymous = false;

    private ?string $promotion = null;

    private int $response_count = 0;

    /**
     * @var Collection<FeedbackResponse>
     */
    private Collection $responses;

    public function __construct()
    {
        $this->status = 'PENDING';
        $this->responses = new ArrayCollection();
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function isIsRead(): bool
    {
        return $this->is_read;
    }

    public function setIsRead(bool $is_read): self
    {
        $this->is_read = $is_read;

        return $this;
    }

    public function getPromotion(): ?string
    {
        return $this->promotion;
    }

    public function setPromotion(?string $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function isIsAnonymous(): bool
    {
        return $this->is_anonymous;
    }

    public function setIsAnonymous(bool $is_anonymous): self
    {
        $this->is_anonymous = $is_anonymous;

        return $this;
    }

    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(FeedbackResponse $response): self
    {
        if (! $this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setFeedback($this);
        }

        return $this;
    }

    public function removeResponse(FeedbackResponse $response): self
    {
        if ($this->responses->removeElement($response)) {
            if ($response->getFeedback() === $this) {
                $response->setFeedback(null);
            }
        }

        return $this;
    }

    public function getResponseCount(): int
    {
        return $this->response_count;
    }

    public function setResponseCount(int $response_count): self
    {
        $this->response_count = $response_count;

        return $this;
    }

    public function increaseResponseCount(): self
    {
        ++$this->response_count;

        return $this;
    }

    public function decreaseResponseCount(): self
    {
        --$this->response_count;

        return $this;
    }
}
