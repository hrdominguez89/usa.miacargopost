<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/office-postal')]

class OfficePostalController extends AbstractController
{
    #[Route('/{status}', name: 'app_secure_office_postal')]
    public function index($status="office"): Response
    {
        return $this->render('secure/office_postal/index.html.twig', [
            'controller_name' => 'OfficePostalController',
            'active' => 'office',
        ]);
    }
}
