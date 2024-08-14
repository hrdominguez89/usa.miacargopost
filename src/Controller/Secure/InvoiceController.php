<?php

namespace App\Controller\Secure;

use App\Entity\Invoice;
use App\Entity\Order;
use App\Form\InvoiceType;
use App\Pagination\Pagination;
use App\Repository\InvoiceRepository;
use App\Repository\OrderRepository;
use App\Service\CRM2Service;
use Knp\Snappy\Pdf;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/invoice')]
class InvoiceController extends AbstractController
{
    #[Route('/', name: 'app_invoice_index', methods: ['GET', 'POST'])]
    public function index(Request $request, InvoiceRepository $repository, Pagination $pagination): Response
    {
        if ($request->isMethod('post')) {
            return $this->json($pagination->paginate($request, $repository));
        }

        return $this->render('invoice/index.html.twig', ['active' => 'invoice']);
    }

    #[Route('/new/{id}', name: 'app_invoice_new', requirements: ['id' => '\d+'], defaults: ['id' => 0], methods: [
        'GET',
        'POST',
    ])]
    public function new(
        #[CurrentUser] UserInterface $user,
        Request $request,
        EventDispatcherInterface $eventDispatcher,
        InvoiceRepository $invoiceRepository,
        OrderRepository $orderRepository,
        CRM2Service $CRM2Service,
        Pdf $knpSnappyPdf,
        Order $order,
        string $invoiceDirectory
    ): Response {

        if ($order->getInvoice() && $request->isMethod('get')) {
            return $this->redirectToRoute(
                'app_invoice_edit',
                ['id' => $order->getInvoice()->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        $entity = new Invoice($order);
        $entity->setEmployeeName($user->getUserIdentifier());

        /** @noinspection DuplicatedCode */
        $form = $this->createForm(InvoiceType::class, $entity);
        $form->handleRequest($request);

        $entity->calculateAmount();

        if ($form->isSubmitted() && $form->isValid()) {
            $invoiceRepository->save($entity, true);

            // SEND EMAIL
            $fileName = 'invoice-' . $entity->getId() . '-' . $order->getOrderId() . '.pdf';
            $file = $invoiceDirectory . '/' . $fileName;
            $knpSnappyPdf->generate($this->generateUrl(
                'app_default_invoice_show', 
                ['id' => $entity->getId()], 
                UrlGeneratorInterface::ABSOLUTE_URL
            ), $file, ['orientation' => 'Landscape'], true);

            $event = new GenericEvent(
                [
                    'email_to' => $order->getCustomer()->getEmail(),
                    'subject' => 'ENVIAMOS LA FACTURA PROFORMA',
                    'customer_name' => $order->getCustomer()->getName(),
                    'template' => 'send_invoice',
                    'add_part_file' => $file,
                ]
            );
            $eventDispatcher->dispatch($event, 'api.executed.send_mail_orden');

            // SEND INFO TO STORE
            $orderRepository->save($order->setBillFile($request->getSchemeAndHttpHost() . '/uploads/payments/invoice/' . $fileName), true);
            $CRM2Service->patchOrder($entity->getOrder()->getOrderId(), $entity->getOrder()->toArray());

            $this->addFlash('notice', 'Acción realizada correctamente');

            return $this->redirectToRoute('app_invoice_edit', ['id' => $entity->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('invoice/new.html.twig', [
            'invoice' => $entity,
            'order' => $order,
            'form' => $form,
            'active' => 'invoice',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_invoice_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, InvoiceRepository $repository, Invoice $entity, CRM2Service $CRM2Service): Response
    {
        /** @noinspection DuplicatedCode */
        $form = $this->createForm(InvoiceType::class, $entity);
        $form->handleRequest($request);

        $entity->calculateAmount();

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($entity, true);
            $CRM2Service->patchOrder($entity->getOrder()->getOrderId(), $entity->getOrder()->toArray());
            $this->addFlash('notice', 'Acción realizada correctamente');

            return $this->redirectToRoute('app_invoice_edit', ['id' => $entity->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invoice/edit.html.twig', [
            'invoice' => $entity,
            'order' => $entity->getOrder(),
            'form' => $form,
            'active' => 'invoice',
        ]);
    }

    #[Route('/delete-more', name: 'app_invoice_delete_more', methods: ['DELETE'])]
    public function deleteMore(Request $request, InvoiceRepository $repository, string $invoiceDirectory): Response
    {

        $ids = explode(',', $request->get('ids', []));

        foreach ($ids as $id) {
            $entity = $repository->find($id);
            if ($entity) {

                try {
                    $fileName = $invoiceDirectory . '/invoice-' . $entity->getId() . '-' . $entity->getOrder()->getOrderId() . '.pdf';
                    
                    if (file_exists($fileName)) {
                        unlink($fileName);
                    }
                } catch (\Exception) {
                }

                $repository->remove($entity, true);
            }
        }

        $this->addFlash('notice', 'Acción realizada correctamente');

        return $this->json('OK');

    }
}
