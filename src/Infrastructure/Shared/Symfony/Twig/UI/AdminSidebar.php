<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Twig\UI;

use Infrastructure\Shared\Symfony\Twig\Sidebar\AbstractSidebar;
use Infrastructure\Shared\Symfony\Twig\Sidebar\SidebarBuilderInterface;
use Infrastructure\Shared\Symfony\Twig\Sidebar\SidebarCollection;

/**
 * class AdminSidebar.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class AdminSidebar extends AbstractSidebar
{
    public function build(SidebarBuilderInterface $builder): SidebarCollection
    {
        $builder
            ->addLink('administration_feedback_dashboard', 'Dashboard', 'growth-fill')
            ->addLink('administration_feedback_index', 'Feedbacks', 'comments')
        ;

        return $builder->create();
    }
}
