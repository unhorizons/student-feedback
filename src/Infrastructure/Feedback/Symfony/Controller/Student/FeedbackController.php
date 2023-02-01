<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Symfony\Controller\Student;

use Application\Feedback\Command\CreateFeedbackCommand;
use Application\Feedback\Command\DeleteFeedbackCommand;
use Application\Feedback\Command\UpdateFeedbackCommand;
use Domain\Feedback\Entity\Feedback;
use Infrastructure\Feedback\Doctrine\Repository\FeedbackRepository;
use Infrastructure\Feedback\Symfony\Form\CreateFeedbackForm;
use Infrastructure\Feedback\Symfony\Form\UpdateFeedbackForm;
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
#[Route('/profile/feedbacks', 'feedback_')]
final class FeedbackController extends AbstractCrudController
{
    protected const DOMAIN = 'feedback';
    protected const ENTITY = 'feedback';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(FeedbackRepository $repository): Response
    {
        return $this->render(
            view: '@app/domain/feedback/index.html.twig',
            parameters: [
                'data' => $this->paginator->paginate(
                    target: $repository->findBy([
                        'owner' => $this->getUser(),
                    ], orderBy: [
                        'created_at' => 'DESC',
                    ]),
                    page: $this->request->query->getInt('page', 1),
                    limit: 50
                ),
            ]
        );
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function show(Feedback $row): Response
    {
        //$this->denyAccessUnlessGranted('FEEDBACK_VIEW');

        return $this->render(
            view: '@app/domain/feedback/show.html.twig',
            parameters: [
                'data' => $row,
            ]
        );
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        $owner = $this->getUser();
        $command = new CreateFeedbackCommand($owner);
        $turbo = $this->request->headers->get('Turbo-Frame');
        $form = $this->createForm(CreateFeedbackForm::class, $command, [
            'action' => $this->generateUrl('feedback_new'),
        ])->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessfullActionFlash();

                return $this->redirectSeeOther('feedback_index');
            } catch (\Throwable $e) {
                if ($turbo) {
                    $form->addError($this->addSafeMessageExceptionError($e));
                } else {
                    $this->addSafeMessageExceptionFlash($e);
                    $response = $this->createUnprocessableEntityResponse();
                }
            }
        }

        return $this->render(
            view: '@app/domain/feedback/new.html.twig',
            parameters: [
                'form' => $form,
                '_turbo_frame_target' => $turbo,
            ],
            response: $response ?? null
        );
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Feedback $row): Response
    {
        //$this->denyAccessUnlessGranted('FEEDBACK_UPDATE', $row);

        $command = new UpdateFeedbackCommand($row);
        $turbo = $this->request->headers->get('Turbo-Frame');
        $form = $this->createForm(UpdateFeedbackForm::class, $command, [
            'action' => $this->generateUrl('feedback_edit', [
                'id' => $row->getId(),
            ]),
        ])->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessfullActionFlash();

                return $this->redirectSeeOther('feedback_index');
            } catch (\Throwable $e) {
                if ($turbo) {
                    $form->addError($this->addSafeMessageExceptionError($e));
                } else {
                    $this->addSafeMessageExceptionFlash($e);
                    $response = $this->createUnprocessableEntityResponse();
                }
            }
        }

        return $this->render(
            view: '@app/domain/feedback/edit.html.twig',
            parameters: [
                'form' => $form,
                '_turbo_frame_target' => $turbo,
            ],
            response: $response ?? null
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(Feedback $row): Response
    {
        //$this->denyAccessUnlessGranted('FEEDBACK_DELETE', $row);

        return $this->executeDeleteCommand(new DeleteFeedbackCommand($row), $row);
    }
}
