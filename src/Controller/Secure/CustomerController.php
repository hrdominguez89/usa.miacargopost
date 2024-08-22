<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/customer')]

class CustomerController extends AbstractController
{
    #[Route('/${status}', name: 'app_secure_customer')]
    public function index($status="customer"): Response
    {
        return $this->render('secure/customer/index.html.twig', [
            'controller_name' => 'CustomerController',
            'active' => 'customer',
        ]);
    }
}
