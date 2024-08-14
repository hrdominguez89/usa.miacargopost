<?php

namespace App\Controller\Secure;

use App\Entity\Invoice;
use App\Entity\Payment;
use App\Form\PaymentType;
use App\Repository\InvoiceRepository;
use App\Repository\OrderRepository;
use App\Repository\PaymentRepository;
use App\Service\CRM2Service;
use App\Service\FileUploaderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment')]
class PaymentController extends AbstractController
{
    public function index(PaymentRepository $repository, Invoice $invoice): Response
    {
        return $this->render(
            'payment/index.html.twig',
            [
                'payments' => $repository->findBy(['invoice' => $invoice]),
                'payment_type' => $invoice->getOrder()->getPaymentType()->getId(),
                'invoice' => $invoice,
                'order' => $invoice->getOrder(),
                'active' => 'invoice'
            ]
        );
    }

    #[Route('/new/{id}', name: 'app_payment_new', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function new(
        Request $request,
        PaymentRepository $paymentRepository,
        InvoiceRepository $invoiceRepository,
        FileUploaderService $fileUploader,
        Invoice $invoice,
        CRM2Service $CRM2Service
    ): Response {

        $entity = new Payment($invoice);

        $entity->setAmount($invoice->getDeudaRD());

        $form = $this->createForm(PaymentType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (($invoice->getDeudaRD() > 0 || $invoice->getDeudaUSD() > 0) || ($invoice->getStatusInvoice() == 'PAID' && $invoice->getOrder()->getPaymentType()->getId() == 2)) {
                
                /** @var UploadedFile $voucherFileType */
                if ($voucherFileType = $form->get('voucherFileType')->getData()) {
                    $brochureFileName = $fileUploader->upload(
                        $voucherFileType,
                        $this->getParameter('voucher_directory')
                    );
                    // $entity->setVoucherFile($brochureFileName);
                    $entity->setVoucherFile($_ENV['FILES_URL'] . 'payments/voucher/' . $brochureFileName);
                }

                $paymentRepository->save($entity, true);
                $invoice->calculateAmount();
                $invoiceRepository->save($invoice, true);
            }
            $CRM2Service->patchOrder($invoice->getOrder()->getOrderId(), $invoice->getOrder()->toArray());

            $this->addFlash('notice', 'Acción realizada correctamente');

            return $this->redirectToRoute('app_invoice_edit', ['id' => $invoice->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('payment/new.html.twig', [
            'invoice' => $invoice,
            'payment' => $entity,
            'form' => $form,
            'active' => 'invoice'
        ]);
    }

    #[Route('/new-pending/{id}/{k}', name: 'app_payment_new_pending', requirements: [
        'id' => '\d+',
        'k' => '\d+',
    ], methods: ['POST'])]
    public function newPending(
        Request $request,
        OrderRepository $orderRepository,
        InvoiceRepository $invoiceRepository,
        PaymentRepository $paymentRepository,
        Invoice $invoice,
        $k
    ): Response {

        [$order, $payment] = [$invoice->getOrder(), new Payment($invoice)];

        $voucherUrlFile = $order->getPaymentFiles()[$k]['payment_file'] ?? '';

        $payment
            ->setVoucherUrlFile($voucherUrlFile)
            ->setAmount($invoice->getDeudaRD());

        $form = $this->createForm(PaymentType::class, $payment, ['file' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($invoice->getDeudaRD() > 0) {

                $pf = $order->getPaymentFiles();

                $pf[$k]['validated'] = true;

                $order->setPaymentFiles($pf);
                $orderRepository->save($order, true);
                $paymentRepository->save($payment, true);
                $invoice->calculateAmount();
                $invoiceRepository->save($invoice, true);
            }

            $this->addFlash(
                'notice',
                'Acción realizada correctamente'
            );

            return $this->redirectToRoute('app_invoice_edit', ['id' => $invoice->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('payment/new_pending.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
            'k' => $k,
            'active' => 'invoice'
        ]);
    }

    #[Route('/delete/{id}', name: 'app_payment_delete', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function delete(
        PaymentRepository $paymentRepository,
        InvoiceRepository $invoiceRepository,
        FileUploaderService $fileUploader,
        Payment $payment,
    ): Response {

        $invoice = $payment->getInvoice();

        if ($payment->getVoucherFile()) {
            $fileUploader->remove($payment->getVoucherFile(), $this->getParameter('voucher_directory'));
        }

        $paymentRepository->remove($payment, true);
        $invoice->calculateAmount();
        $invoiceRepository->save($invoice, true);

        $this->addFlash('notice', 'Acción realizada correctamente');

        return $this->redirectToRoute('app_invoice_edit', ['id' => $invoice->getId()], Response::HTTP_SEE_OTHER);
    }
}
