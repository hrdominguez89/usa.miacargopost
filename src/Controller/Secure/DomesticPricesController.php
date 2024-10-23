<?php

namespace App\Controller\Secure;

use App\Form\DomesticPricesBaseRatesType;
use App\Service\USPSDomesticPricesApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/domestic-prices')]
class DomesticPricesController extends AbstractController
{
    private $uspsDomesticPricesApiService;

    public function __construct(USPSDomesticPricesApiService $uspsDomesticPricesApiService)
    {
        $this->uspsDomesticPricesApiService = $uspsDomesticPricesApiService;
    }

    #[Route('/', name: 'app_domestic_prices_index')]
    public function index(Request $request): Response
    {
        $data['form'] = $this->createForm(DomesticPricesBaseRatesType::class);

        // Procesar el formulario al enviarlo
        $data['form']->handleRequest($request);

        $data['result'] = null;

        if ($data['form']->isSubmitted() && $data['form']->isValid()) {
            $datoFormulario = $data['form']->getData();

            // Llamada al servicio USPS para validar la dirección
            $data['result'] = $this->uspsDomesticPricesApiService->getBaseRates($datoFormulario);
        }

        // Llamada al servicio
        $data['active'] = 'domestic-prices';
        return $this->render('secure/domestic_prices/index.html.twig', $data);
    }
}
