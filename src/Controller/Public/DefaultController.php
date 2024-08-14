<?php

namespace App\Controller\Public;

use App\Entity\Invoice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/invoice/{id}/show', name: 'app_default_invoice_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showInvoice(Invoice $entity): Response
    {
        return $this->render('invoice/show.html.twig', ['invoice' => $entity, 'order' => $entity->getOrder()]);
    }
}