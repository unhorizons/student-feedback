<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class MainController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class MainController extends AbstractController
{
    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function __invoke(): Response
    {
        if (null !== $this->getUser()) {
            return $this->redirectToRoute('feedback_new');
        }

        return $this->redirectToRoute('authentication_login_index');
    }
}
