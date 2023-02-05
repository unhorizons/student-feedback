<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller;

use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

/**
 * Trait ChartTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait ChartTrait
{
    private function createDistributionChart(ChartBuilderInterface $builder, array $data): Chart
    {
        if (2 === count($data)) {
            [$seen, $unseen] = $data;
        }

        $chart = $builder->createChart(Chart::TYPE_BAR);

        if (2 === count($data) && isset($seen) && isset($unseen)) {
            $chart->setData([
                'labels' => array_keys($seen),
                'datasets' => [
                    [
                        'label' => 'Feedbacks lus',
                        'borderColor' => '#9d72ff',
                        'backgroundColor' => '#9d72ff',
                        'data' => array_values($seen),
                    ],
                    [
                        'label' => 'Feedbacks non lus',
                        'borderColor' => '#eb6459',
                        'backgroundColor' => '#eb6459',
                        'data' => array_values($unseen),
                    ],
                ],
            ]);
        } else {
            $chart->setData([
                'labels' => array_keys($data),
                'datasets' => [
                    [
                        'label' => 'Feedbacks reçus',
                        'borderColor' => '#9d72ff',
                        'backgroundColor' => '#9d72ff',
                        'data' => array_values($data),
                    ],
                ],
            ]);
        }

        $chart->setOptions([
            'plugins' => [
                'tooltip' => [
                    'displayColors' => false,
                ],
                'legend' => [
                    'display' => true,
                    'labels' => [
                        'boxWidth' => 12,
                        'padding' => 20,
                        'fontColor' => '#6783b8',
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'display' => true,
                    'ticks' => [
                        'beginAtZero' => true,
                        'fontSize' => 11,
                        'fontColor' => '#9eaecf',
                        'padding' => 10,
                        'min' => 0,
                        'stepSize' => 1,
                    ],
                ],
                'x' => [
                    'display' => true,
                    'ticks' => [
                        'fontSize' => 9,
                        'fontColor' => '#9eaecf',
                        'source' => 'auto',
                        'padding' => 10,
                    ],
                ],
            ],
        ]);

        return $chart;
    }
}
