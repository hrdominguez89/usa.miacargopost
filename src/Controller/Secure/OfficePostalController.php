<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfficePostalController extends AbstractController
{
    #[Route('/secure/office/postal', name: 'app_secure_office_postal')]
    public function index(): Response
    {
        return $this->render('secure/office_postal/index.html.twig', [
            'controller_name' => 'OfficePostalController',
        ]);
    }
}
