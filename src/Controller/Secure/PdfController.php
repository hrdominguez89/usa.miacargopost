<?php

namespace App\Controller\Secure;

use App\Entity\S10Code;
use App\Repository\S10CodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;
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
    public function index($s10code_id, S10CodeRepository $s10CodeRepository,EntityManagerInterface $em): Response
    {

        $data['s10code'] = $s10CodeRepository->find($s10code_id);
        if ($data['s10code']) {
            if (!$data['s10code']->getNumbercode()) {
                $data['s10code']->setNumbercode($this->generateCode($s10code_id, $s10CodeRepository));
                $em->persist($data['s10code']);
                $em->flush($data['s10code']);
            }
            $this->generateBarcodeImage($data['s10code'], $em);
        } else {
            return $this->redirectToRoute('app_secure_upu');
        }

        $html = $this->renderView('pdf/cn22.html.twig',$data);
        $pdfContent = $this->pdf->getOutputFromHtml($html);
        return new Response($pdfContent, 200, ['Content-Type' => 'application/pdf']);
    }

    private function generateCode($id, S10CodeRepository $s10CodeRepository): string
    {
        $numbers = str_pad($s10CodeRepository->countRecordsByServiceCodeAndCountryBeforeOrEqualToId($id), 8, '0', STR_PAD_LEFT);

        $secuencia = [8, 6, 4, 2, 3, 5, 9, 7];  //numeros que indica la UPU para hacer el calculo

        $suma_total = 0;
        for ($i = 0; $i < 8; $i++) {
            $suma_total += $numbers[$i] * $secuencia[$i];
        }

        $resto = $suma_total % 11; //11 numero que indica la upu para hacer el calculo

        $digito_de_seguridad = 11 - $resto; //11- resto cuenta que indica la upu para hacer el calculo

        //si es 11 el digito de seguridad es 5 si es 10 el digito de seguridad es 0 segun la UPU
        if ($digito_de_seguridad > 10) {
            $digito_de_seguridad = 5;
        }
        if ($digito_de_seguridad == 10) {
            $digito_de_seguridad = 0;
        }
        return $numbers . $digito_de_seguridad;
    }

    private function generateBarcodeImage(S10Code $s10Code, EntityManagerInterface $em): void
    {
        // Definir la ruta del archivo en la carpeta /public/barcodes/s10/
        $codigoS10 = $s10Code->getFormattedNumbercode();
        $rutaArchivo = $this->getParameter('kernel.project_dir') . '/public/barcodes/s10/' . $codigoS10 . '.png';

        // Generar código de barras con picqer/php-barcode-generator (Code128)
        $generator = new BarcodeGeneratorPNG();
        $codigoBarras = $generator->getBarcode($codigoS10, $generator::TYPE_CODE_128);

        // Guardar la imagen en la carpeta /public/barcodes/s10/
        file_put_contents($rutaArchivo, $codigoBarras);

        // Actualizar la entidad S10Code para guardar la ruta de la imagen
        $rutaRelativa = '/barcodes/s10/' . $codigoS10 . '.png';
        $s10Code->setBarcodeImage($rutaRelativa);

        // Persistir los cambios
        $em->persist($s10Code);
        $em->flush();
    }

    #[Route('/cn23/{s10code_id}', name: 'app_pdf_cn23')]
    public function cn23($s10code_id, S10CodeRepository $s10CodeRepository, EntityManagerInterface $em): Response{
        $html = $this->renderView('pdf/cn23.html.twig');
        $options = [
            'orientation' => 'Landscape',
        ];
        $pdfContent = $this->pdf->getOutputFromHtml($html, $options);
       
        return new Response($pdfContent, 200, ['Content-Type' => 'application/pdf']);
    }

}
