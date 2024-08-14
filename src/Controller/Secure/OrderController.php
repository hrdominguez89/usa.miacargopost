<?php

namespace App\Controller\Secure;

use App\Entity\Order;
use App\Pagination\Pagination;
use App\Repository\OrderRepository;
use App\Service\CRM2Service;
use App\Service\InventaryService;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'app_order_index', methods: ['GET', 'POST'])]
    public function index(Request $request, OrderRepository $repository, Pagination $pagination): Response
    {
        if ($request->isMethod('post')) {
            return $this->json($pagination->paginate($request, $repository));
        }

        return $this->render('order/index.html.twig', ['active' => 'orden']);
    }

    #[Route('/{id}/show', name: 'app_order_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(
        Order $order,
        CRM2Service $CRM2Service
    ): Response {
        $invoice = $order->getInvoice()?->calculateAmount();
        $cardnet = $CRM2Service->getOrder($order->getOrderId());
        return $this->render('order/show.html.twig', ['order' => $order, 'invoice' => $invoice, 'cardnet' => $cardnet[1]]);
    }

    #[Route('/{id}/confirm', name: 'app_order_confirm_one', methods: ['GET'])]
    public function confirmOne(
        EventDispatcherInterface $eventDispatcher,
        OrderRepository $repository,
        InventaryService $service,
        CRM2Service $CRM2Service,
        Order $entity
    ): Response {
        try {

            $this->confirmOrden($service, $entity, $repository, $CRM2Service, $eventDispatcher);

            $this->addFlash('notice', 'Acción realizada correctamente');

            return $this->redirectToRoute('app_order_show', ['id' => $entity->getId()], Response::HTTP_SEE_OTHER);
        } catch (\Exception) {

            $this->addFlash('danger', 'Acción no realizada correctamente');

            return $this->redirectToRoute('app_order_show', ['id' => $entity->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/confirm-more', name: 'app_order_confirm', methods: ['POST'])]
    public function confirm(
        Request $request,
        EventDispatcherInterface $eventDispatcher,
        OrderRepository $repository,
        InventaryService $service,
        CRM2Service $CRM2Service
    ): Response {
        try {

            $ids = explode(',', $request->get('ids', []));

            foreach ($ids as $id) {
                if ($entity = $repository->find($id)) {
                    $this->confirmOrden($service, $entity, $repository, $CRM2Service, $eventDispatcher);
                }
            }

            $this->addFlash('notice', 'Acción realizada correctamente');

            return $this->json('OK');
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/delete-more', name: 'app_order_delete_more', methods: ['DELETE'])]
    public function deleteMore(Request $request, EventDispatcherInterface $eventDispatcher, OrderRepository $repository): Response
    {

        $ids = explode(',', $request->get('ids', []));

        foreach ($ids as $id) {
            $entity = $repository->find($id);
            if ($entity) {
                $repository->save($entity->setStatusOrder('ANULADO'), true);

                $event = new GenericEvent(
                    [
                        'email_to' => $entity->getCustomer()->getEmail(),
                        'subject' => 'ANULACIÓN DE ORDEN',
                        'customer_name' => $entity->getCustomer()->getName(),
                        'template' => 'confirmation_anulation_orden',
                    ]
                );
                $eventDispatcher->dispatch($event, 'api.executed.send_mail_orden');
            }
        }

        $this->addFlash('notice', 'Acción realizada correctamente');

        return $this->json('OK');
    }

    /**
     * @param InventaryService $service
     * @param Order $entity
     * @param OrderRepository $repository
     * @param CRM2Service $CRM2Service
     * @param EventDispatcherInterface $eventDispatcher
     * @return void
     */
    private function confirmOrden(
        InventaryService $service,
        Order $entity,
        OrderRepository $repository,
        CRM2Service $CRM2Service,
        EventDispatcherInterface $eventDispatcher
    ): void {
        $service->confirmOrder($entity->getInventoryId());
        $repository->save($entity->setStatusOrder(6), true);
        $CRM2Service->patchOrder($entity->getOrderId(), $entity->toArray());

        $event = new GenericEvent(
            [
                'email_to' => $entity->getCustomer()->getEmail(),
                'subject' => 'TU ORDEN SE ENCUENTRA CONFIRMADA',
                'customer_name' => $entity->getCustomer()->getName(),
                'template' => 'confirm_orden',
            ]
        );
        $eventDispatcher->dispatch($event, 'api.executed.send_mail_orden');
    }
}
