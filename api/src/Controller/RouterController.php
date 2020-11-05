<?php

namespace App\Controller;

use App\Manager\RouterManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RouterController extends AbstractController
{
    /**
     * @Route(path="/{req}", name="catch_all_route", requirements={"req"=".+"})
     */
    public function catchAllRoute(Request $request, RouterManager $routerManager)
    {
        return $routerManager->trackRoute($request);

    }
}