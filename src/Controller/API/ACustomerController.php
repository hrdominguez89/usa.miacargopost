<?php

namespace App\Controller\API;

use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/acustomer')]
class ACustomerController extends AbstractController
{
    #[Route('/', name: 'app_acustomer_index')]
    public function index(
        Request $request,
        CustomerRepository $customerRepository,
        ValidatorInterface $validator
    ): Response {

        try {

            $raw = $request->toArray();

            [$customer, $status] = $customerRepository->createAPICustomer($raw);

            // check errors
            $er = $validator->validate($customer);
            if (count($er) > 0) {
                return $this->json(['msg' => $er->get(0)->getMessage(), 'p' => $er->get(0)->getPropertyPath()], 422);
            }

            $customerRepository->save($customer, true);

            return $this->json(
                [
                    'status' => $status == 201 ? 'Creado correctamente' : 'Actualizado correctamente',
                    'customer' => $customer,
                ],
                $status
            );

        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }
}
