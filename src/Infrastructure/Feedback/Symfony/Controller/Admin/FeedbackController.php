<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Symfony\Controller\Admin;

use Application\Feedback\Command\SetFeedbackViewedCommand;
use Domain\Feedback\Entity\Feedback;
use Infrastructure\Feedback\Doctrine\Repository\FeedbackRepository;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class FeedbackController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/feedbacks', 'administration_feedback_')]
final class FeedbackController extends AbstractCrudController
{
    protected const DOMAIN = 'feedback';
    protected const ENTITY = 'feedback';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(FeedbackRepository $repository): Response
    {
        $is_read = $this->request->query->get('is_read', null);

        return $this->render(
            view: $this->getViewPath('index'),
            parameters: [
                'data' => $this->paginator->paginate(
                    target: $repository->findBy(
                        criteria: null !== $is_read ? [
                            'is_read' => $is_read,
                        ] : [],
                        orderBy: [
                            'created_at' => 'DESC',
                        ]
                    ),
                    page: $this->request->query->getInt('page', 1),
                    limit: 50
                ),
            ]
        );
    }

    #[Route("/{id<\d+>}", name: 'show', methods: ['GET'])]
    public function show(Feedback $row): Response
    {
        if (false === $row->isIsRead()) {
            try {
                $this->dispatchSync(new SetFeedbackViewedCommand($row));
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage(), $e->getTrace());
            }
        }

        return $this->render(
            view: '@admin/domain/feedback/feedback/show.html.twig',
            parameters: [
                'data' => $row,
            ]
        );
    }
}
