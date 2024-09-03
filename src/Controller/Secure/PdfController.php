<?php

namespace App\Controller\Secure;

use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pdf')]
class PdfController extends AbstractController
{
    private $pdf;
    public function __construct(Pdf $pdf){
        $this->pdf = $pdf;     
    }
    #[Route('/cn22', name: 'app_pdf_cn22')]
    public function index(): Response
    {
        $html = $this->renderView('pdf/cn22.html.twig');
        $pdfContent = $this->pdf->getOutputFromHtml($html);
        return new Response($pdfContent, 200, ['Content-Type' => 'application/pdf']);
        
    }
}
