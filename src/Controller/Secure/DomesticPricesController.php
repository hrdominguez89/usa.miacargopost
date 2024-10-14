<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/domestic-prices')]
class DomesticPricesController extends AbstractController
{
    #[Route('/', name: 'app_domestic_prices_index')]
    public function index(): Response
    {
        $data['active'] = 'domestic-prices';
        return $this->render('secure/domestic_prices/index.html.twig', $data);
    }
}
