<?php

declare(strict_types=1);

namespace Infrastructure\Feedback\Symfony\Controller\Admin;

use Domain\Feedback\Repository\FeedbackRepositoryInterface;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Infrastructure\Shared\Symfony\Controller\ChartTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

/**
 * class DashboardController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DashboardController extends AbstractController
{
    use ChartTrait;

    #[Route('/admin/feedback/dashboard', name: 'administration_feedback_dashboard', methods: ['GET'])]
    public function index(
        FeedbackRepositoryInterface $repository,
        ChartBuilderInterface $builder
    ): Response {
        $data = $repository->findStats();
        $chart = $this->createDistributionChart($builder, $repository->findCurrentYearFrequency());

        return $this->render(
            view: '@admin/domain/feedback/feedback/dashboard.html.twig',
            parameters: [
                'data' => $data,
                'chart' => $chart,
            ]
        );
    }
}
