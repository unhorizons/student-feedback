<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Symfony\Controller\Admin;

use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class DashboardController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DashboardController extends AbstractController
{
    #[Route('/admin/feedback/dashboard', name: 'administration_feedback_dashboard', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('@admin/domain/feedback/feedback/dashboard.html.twig');
    }
}
