<?php

namespace App\Controller\API;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Service\CRM2Service;
use App\Service\InventaryService;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[Route('/aorder')]
class AOrderController extends AbstractController
{

    #[Route('/', name: 'app_aorder_index')]
    public function index(
        Request $request,
        EventDispatcherInterface $eventDispatcher,
        OrderRepository $orderRepository,
        ValidatorInterface $validator,
        InventaryService $service,
        CRM2Service $CRM2Service
    ): Response {

        $dataToInventory = [];

        try {

            $raw = $request->toArray();
            $entity = $orderRepository->createAPIOrder($raw);

            // check errors
            $er = $validator->validate($entity);
            if (count($er) > 0) {
                return $this->json(
                    ['msg' => $er->get(0)->getMessage(), 'p' => $er->get(0)->getPropertyPath()],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $dataToInventory = $entity->toInventoryArray();
            $data = $service->createSaleOrder($dataToInventory);
            $status = isset($data['id']) ? 201 : 500;
            $oArray = [];

            if ($status == 201) {
                $orderRepository->save($entity->setInventoryId($data['id']), true);
                $oArray = $entity->toArray();
                $CRM2Service->patchOrder($entity->getOrderId(), $oArray);

                $event = new GenericEvent(
                    [
                        'email_to' => $entity->getCustomer()->getEmail(),
                        'subject' => 'RECIBIMOS TU ORDEN',
                        'customer_name' => $entity->getCustomer()->getName(),
                        'template' => 'create_orden',
                    ]
                );
                $eventDispatcher->dispatch($event, 'api.executed.send_mail_orden');
            }

            return $this->json(
                [
                    'status' => $status == 201 ? 'Creado correctamente' : 'No se pudo crear la orden',
                    'order' => $status == 201 ? $oArray : [],
                    'inventory_response' => json_encode($data),
                    'data_json' => $raw,
                ],
                $status
            );
        } catch (\Exception | DecodingExceptionInterface | TransportExceptionInterface | ServerExceptionInterface $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ClientExceptionInterface | RedirectionExceptionInterface $exception) {

            $response = $exception->getResponse();

            /** @noinspection PhpUnhandledExceptionInspection */
            return $this->json(
                array_merge(
                    ['response_inventory' => json_decode($response->getContent(false), true),],
                    ['data_send_to_inventory' => $dataToInventory]
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #[Route('/show/{order_id}/details', name: 'app_aorder_show')]
    #[Entity('order', expr: 'repository.findOneByOrderId(order_id)')]
    public function show(Order $order): Response
    {
        return $this->json($order->toArray());
    }

    #[Route('/update', name: 'app_aorder_udpate')]
    public function update(
        Request $request,
        LoggerInterface $logger,
        EventDispatcherInterface $eventDispatcher,
        OrderRepository $orderRepository,
        ValidatorInterface $validator,
        CRM2Service $CRM2Service
    ): Response {

        try {
            $raw = $request->toArray();

            if (!$entity = $orderRepository->updateAPIOrder($raw)) {
                throw $this->createNotFoundException("Order with sales_id " . $raw['sales_id'] . " not found.");
            }

            // check errors
            $er = $validator->validate($entity);
            if (count($er) > 0) {
                return $this->json(
                    ['msg' => $er->get(0)->getMessage(), 'p' => $er->get(0)->getPropertyPath()],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $orderRepository->save($entity, true);
            $dataToStore = $entity->toArray();
            $CRM2Service->patchOrder($entity->getOrderId(), $dataToStore);

            if ((int)$raw['status_order'] == 3 || $entity->getStatusOrder() == 'Shipped') {
                $event = new GenericEvent(
                    [
                        'email_to' => $entity->getCustomer()->getEmail(),
                        'subject' => 'TU ORDEN SE ENCUENTRA DESPACHADA',
                        'customer_name' => $entity->getCustomer()->getName(),
                        'template' => 'send_orden',
                    ]
                );
                $eventDispatcher->dispatch($event, 'api.executed.send_mail_orden');
            }

            return $this->json(
                [
                    'status' => 'Actualizado correctamente',
                    'order' => $entity->toArray(),
                    'data_json' => $raw,
                ],
            );
        } catch (ClientExceptionInterface | RedirectionExceptionInterface $exception) {

            $response = $exception->getResponse();

            /** @noinspection PhpUnhandledExceptionInspection */
            $logger->critical('PATCH_TO_STORE_ERROR_CRITICAL_111', [
                'order_id' => isset($entity) ? $entity->getOrderId() : null,
                'data_to_store' => isset($entity) ? $entity->toArray() : [],
                'response_store' => json_decode($response->getContent(false), true),
            ]);

            /** @noinspection PhpUnhandledExceptionInspection */
            return $this->json(
                array_merge(
                    ['response_store' => json_decode($response->getContent(false), true)],
                    ['data_send_to_store' => $dataToStore ?? []]
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (\Exception | ServerExceptionInterface $exception) {

            $logger->critical('PATCH_TO_STORE_ERROR_CRITICAL_222', [
                'order_id' => isset($entity) ? $entity->getOrderId() : null,
                'data_to_store' => isset($entity) ? $entity->toArray() : [],
                'error' => $exception->getMessage(),
            ]);

            return $this->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
