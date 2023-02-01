<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Symfony\Controller\Admin;

use Application\Feedback\Command\CreateFeedbackResponseCommand;
use Application\Feedback\Command\DeleteFeedbackResponseCommand;
use Application\Feedback\Command\UpdateFeedbackResponseCommand;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Entity\FeedbackResponse;
use Infrastructure\Feedback\Symfony\Form\CreateFeedbackResponseForm;
use Infrastructure\Feedback\Symfony\Form\UpdateFeedbackResponseForm;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PostController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/feedback/response', 'administration_feedback_feedback_response_')]
final class FeedbackResponseController extends AbstractCrudController
{
    protected const DOMAIN = 'feedback';
    protected const ENTITY = 'feedback_response';

    #[Route('/{id}/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Feedback $feedback): Response
    {
        $owner = $this->getUser();

        return $this->executeFormCommand(
            new CreateFeedbackResponseCommand($owner, $feedback),
            CreateFeedbackResponseForm::class
        );
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return new RedirectResponse(
            $request->headers->get('referer') ??
                $this->generateUrl('administration_feedback_index')
        );
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(FeedbackResponse $response): Response
    {
        return $this->redirectToRoute('administration_feedback_show', [
            'id' => $response->getFeedback()?->getId(),
        ]);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(FeedbackResponse $row): Response
    {
        //$this->denyAccessUnlessGranted('FEEDBACK_RESPONSE_UPDATE', $row);

        return $this->executeFormCommand(
            command: new UpdateFeedbackResponseCommand($row),
            formClass: UpdateFeedbackResponseForm::class,
            row: $row,
            view: 'edit'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['DELETE'])]
    public function delete(FeedbackResponse $row): Response
    {
        //$this->denyAccessUnlessGranted('FEEDBACK_RESPONSE_DELETE');

        return $this->executeDeleteCommand(new DeleteFeedbackResponseCommand($row), $row);
    }
}
