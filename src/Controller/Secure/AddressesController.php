<?php

namespace App\Controller\Secure;

use App\Form\AddressType;
use App\Form\CityAndStateType;
use App\Form\ZipCodeType;
use App\Service\USPSAddressApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/addresses')]
class AddressesController extends AbstractController
{
    private $uspsAddressApiService;

    public function __construct(USPSAddressApiService $uspsAddressApiService)
    {
        $this->uspsAddressApiService = $uspsAddressApiService;
    }

    #[Route('/', name: 'app_addresses_index')]
    public function index(Request $request): Response
    {
        $address = [
            'streetAddress' => '3120 M St',
            'secondaryAddress' => 'NW',
            'city' => 'Washington',
            'state' => 'DC',
            'ZIPCode' => '20007',
            'ZIPPlus4' => '1234'
        ];

        // Llamada al servicio
        $data['result'] = $this->uspsAddressApiService->getAddress($address);
        $data['active'] = 'addresses';
        return $this->render('secure/addresses/index.html.twig', $data);
    }

    #[Route('/address', name: 'app_addresses_address')]
    public function address(Request $request): Response
    {
        $data['form'] = $this->createForm(AddressType::class);

        // Procesar el formulario al enviarlo
        $data['form']->handleRequest($request);

        $data['result'] = null;

        if ($data['form']->isSubmitted() && $data['form']->isValid()) {
            $addressData = $data['form']->getData();

            // Llamada al servicio USPS para validar la dirección
            $data['result'] = $this->uspsAddressApiService->getAddress($addressData);
        }

        // Llamada al servicio
        $data['active'] = 'addresses';
        return $this->render('secure/addresses/address.html.twig', $data);
    }

    #[Route('/city-and-state', name: 'app_addresses_city_and_state')]
    public function cityAndState(Request $request): Response
    {
        $data['form'] = $this->createForm(CityAndStateType::class);

        // Procesar el formulario al enviarlo
        $data['form']->handleRequest($request);

        $data['result'] = null;

        if ($data['form']->isSubmitted() && $data['form']->isValid()) {
            $zipCodeData = $data['form']->getData();

            // Llamada al servicio USPS para validar la dirección
            $data['result'] = $this->uspsAddressApiService->getCityAndState($zipCodeData);
        }

        // Llamada al servicio
        $data['active'] = 'addresses';
        return $this->render('secure/addresses/city_and_state.html.twig', $data);
    }

    #[Route('/zip-code', name: 'app_addresses_zip_code')]
    public function zipCode(Request $request): Response
    {
        $data['form'] = $this->createForm(ZipCodeType::class);

        // Procesar el formulario al enviarlo
        $data['form']->handleRequest($request);

        $data['result'] = null;

        if ($data['form']->isSubmitted() && $data['form']->isValid()) {
            $addressData = $data['form']->getData();

            // Llamada al servicio USPS para validar la dirección
            $data['result'] = $this->uspsAddressApiService->getZipCode($addressData);
        }

        // Llamada al servicio
        $data['active'] = 'addresses';
        return $this->render('secure/addresses/zip_code.html.twig', $data);
    }
}
