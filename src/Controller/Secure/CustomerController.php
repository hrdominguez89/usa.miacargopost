<?php

namespace App\Controller\Secure;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Pagination\Pagination;
use App\Repository\CustomerRepository;
use App\Service\CRM2Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

#[Route('/customer')]
class CustomerController extends AbstractController
{
    #[Route('/', name: 'app_customer_index', methods: ['GET', 'POST'])]
    public function index(Request $request, CustomerRepository $repository, Pagination $pagination): Response
    {
        if ($request->isMethod('post')) {
            return $this->json($pagination->paginate($request, $repository));
        }

        return $this->render('customer/index.html.twig', ['active' => 'customer']);
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     */
    #[Route('/{id}/edit', name: 'app_customer_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        CustomerRepository $repository,
        CRM2Service $service,
        Customer $entity,
    ): Response {
        $form = $this->createForm(CustomerType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $apiResponse = $service->patchCustomer($entity->getApiId(), $entity->toArray());

            if ($apiResponse[0] == 200) {

                $repository->save($entity, true);

                $this->addFlash('notice', 'Acción realizada correctamente');

                return $this->redirectToRoute('app_customer_index', [], Response::HTTP_SEE_OTHER);
            }

            $form->addError(new FormError($apiResponse[1]));
        }

        return $this->render('customer/edit.html.twig', ['customer' => $entity, 'form' => $form, 'active' => 'customer']);
    }

    #[Route('/delete-more', name: 'app_customer_delete', methods: ['DELETE'])]
    public function delete(Request $request, CustomerRepository $repository): Response
    {

        $ids = explode(',', $request->get('ids', []));

        foreach ($ids as $id) {
            $entity = $repository->find($id);
            if ($entity) {
                $repository->remove($entity, true);
            }
        }

        $this->addFlash('notice', 'Acción realizada correctamente');

        return $this->json('OK');

    }
}
