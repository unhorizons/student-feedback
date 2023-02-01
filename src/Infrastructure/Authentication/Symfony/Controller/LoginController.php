<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Application\Authentication\Command\RequestLoginLinkCommand;
use Infrastructure\Authentication\Symfony\Form\RequestLoginLinkForm;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class LoginLinkController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/login', name: 'authentication_')]
final class LoginController extends AbstractController
{
    #[Route('', name: 'login_index', methods: ['GET', 'POST'])]
    public function request(Request $request): Response
    {
        if ($this->getUser()) {
            $this->redirectToRoute('app_index');
        }

        $command = new RequestLoginLinkCommand();
        $form = $this->createForm(RequestLoginLinkForm::class, $command)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessFlash(
                    id: 'authentication.flashes.login_link_requested_successfully',
                    domain: 'authentication'
                );

                return $this->redirectSeeOther('authentication_login_index');
            } catch (AuthenticationException) {
                $this->addSomethingWentWrongFlash();
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
            }

            $response = new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->render(
            view: '@app/domain/authentication/login.html.twig',
            parameters: [
                'form' => $form,
            ],
            response: $response ?? null
        );
    }

    #[Route('/check', name: 'login_check', methods: ['GET'])]
    public function check(): never
    {
        throw new \LogicException('This code should never be reached');
    }

    #[Route('/logout', name: 'logout', methods: ['GET', 'POST'])]
    public function logout(): never
    {
        throw new \LogicException('This code should never be reached');
    }
}
