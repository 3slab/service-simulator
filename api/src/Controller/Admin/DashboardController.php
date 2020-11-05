<?php

namespace App\Controller\Admin;

use App\Entity\PreconfigureResponse;
use App\Entity\Request as SimulatorRequest;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $preconfigureResponseUrl = $this->get(CrudUrlGenerator::class)->build()->setController(PreconfigureResponseCrudController::class)->generateUrl();

        return $this->redirect($preconfigureResponseUrl);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Preconfigure Response', 'fa  fa-list', PreconfigureResponse::class);
        yield MenuItem::linkToCrud('Request', 'fa  fa-list', SimulatorRequest::class);
    }
}
