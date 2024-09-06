<?php

namespace App\Controller\Secure;

use App\Repository\S10CodeRepository;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pdf')]
class PdfController extends AbstractController
{
    private $pdf;
    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }
    #[Route('/cn22/{s10code_id}', name: 'app_pdf_cn22')]
    public function index($s10code_id, S10CodeRepository $s10CodeRepository): Response
    {

        $data['s10code'] = $s10CodeRepository->find($s10code_id);
        if (!$data['s10code']) {
            $this->redirectToRoute('app_secure_upu');
        }

        $html = $this->renderView('pdf/cn22.html.twig',$data);
        $pdfContent = $this->pdf->getOutputFromHtml($html);
        return new Response($pdfContent, 200, ['Content-Type' => 'application/pdf']);
    }
}
