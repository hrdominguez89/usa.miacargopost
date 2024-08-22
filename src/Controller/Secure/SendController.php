<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/send')]

class SendController extends AbstractController
{
    #[Route('/{status}', name: 'app_secure_send')]
    public function index($status="inoffice"): Response
    {
        return $this->render('secure/send/index.html.twig', [
            'controller_name' => 'SendController',
            'active'=>'send'
        ]);
    }
}
