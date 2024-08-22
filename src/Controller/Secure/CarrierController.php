<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/carrier')]

class CarrierController extends AbstractController
{
    #[Route('/{$status}', name: 'app_secure_carrier')]
    public function index($status="carrier"): Response
    {
        return $this->render('secure/carrier/index.html.twig', [
            'controller_name' => 'CarrierController',
            'active' => 'carrier',
        ]);
    }
}
