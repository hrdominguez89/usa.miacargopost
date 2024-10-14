<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/addresses')]
class AddressesController extends AbstractController
{
    #[Route('/', name: 'app_addresses_index')]
    public function index(): Response
    {
        $data['active'] = 'addresses';
        return $this->render('secure/addresses/index.html.twig', $data);
    }
}
