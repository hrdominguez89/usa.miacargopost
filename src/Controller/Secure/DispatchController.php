<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dispatch')]
class DispatchController extends AbstractController

{
    #[Route('/{status?}', name: 'app_secure_dispatch_index')]
    public function index($status="open"): Response
    {

        return $this->render('secure/dispatch/index.html.twig', [
            'controller_name' => 'DispatchController',
            'active'=>'dispatch'
        ]);
    }

    #[Route('/i/new', name: 'app_secure_dispatch')]
    public function new(): Response
    {
        return $this->render('secure/dispatch/new.html.twig', [
            'controller_name' => 'DispatchController',
            'active'=>'dispatch'
        ]);
    }
}
