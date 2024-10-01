<?php

namespace App\Controller\Secure;

use App\Entity\ItemDetail;
use App\Entity\S10Code;
use App\Form\S10CodeType;
use App\Repository\PostalServiceRepository;
use App\Repository\S10CodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/upu')]
class UpuController extends AbstractController
{
    #[Route('/s10/{id?}', name: 'app_secure_upu')]
    public function index(Request $request, EntityManagerInterface $em, PostalServiceRepository $postalServiceRepository, S10CodeRepository $s10CodeRepository, $id = false): Response
    {
        if ($id) {
            $data['s10CodeGenerated'] = $s10CodeRepository->find((int)$id);
            if ($data['s10CodeGenerated']) {
                if (!$data['s10CodeGenerated']->getNumbercode()) {
                    $data['s10CodeGenerated']->setNumbercode($this->generateCode($id, $s10CodeRepository));
                    $em->persist($data['s10CodeGenerated']);
                    $em->flush($data['s10CodeGenerated']);
                }
                $this->generateBarcodeImage($data['s10CodeGenerated'], $em);
            } else {
                return $this->redirectToRoute('app_secure_upu');
            }
        }
        $data['s10codes'] = $s10CodeRepository->findAll();

        $data['s10Code'] = new S10Code();

        $data['s10Code']->addItemDetail(new ItemDetail());

        $data['active'] = 'S10';

        $data['form'] = $this->createForm(S10CodeType::class, $data['s10Code']);
        $data['form']->handleRequest($request);

        if ($data['form']->isSubmitted() && $data['form']->isValid()) {

            $postalService = $postalServiceRepository->find($request->get('s10_code')['postalService']);
            // $postalService->getPostalServiceRanges()[0] con esto traigo solo el primer array que me interesa, esto es por ahora
            $data['s10Code']->setPostalServiceRange($postalService->getPostalServiceRanges()[0])
                ->setServiceCode($postalService->getPostalServiceRanges()[0]->getPrincipalCharacter() . $postalService->getPostalServiceRanges()[0]->getSecondCharacterFrom());

            $totalValue = 0;
            $totalWeight = 0;
            foreach ($data['s10Code']->getItemDetails() as $itemDetail) {
                $totalWeight += $itemDetail->getNetWeight();
                $totalValue += $itemDetail->getValue();
                $em->persist($itemDetail);
            }
            $data['s10Code']->setTotalValue($totalValue);
            $data['s10Code']->setTotalGrossWeight($totalWeight);
            $em->persist($data['s10Code']);
            $em->flush();

            $data['s10Code']->setNumbercode($this->generateCode($data['s10Code']->getId(), $s10CodeRepository));

            $this->generateBarcodeImage($data['s10Code'], $em);

            $em->persist($data['s10Code']);
            $em->flush();

            return $this->redirectToRoute('app_secure_upu', ['id' => $data['s10Code']->getId()]);
        }

        return $this->render('secure/upu/index.html.twig', $data);
    }

    #[Route('/postalService', name: 'app_secure_postal_service', methods: ['POST'])]
    public function postalService(PostalServiceRepository $postalServiceRepository, Request $request): JsonResponse
    { {
            $data = json_decode($request->getContent(), true);
            // Obtener el ID desde el cuerpo de la solicitud
            $id = $data['id'] ?? null;

            // Verificar si se proporcionó un ID
            if (!$id) {
                return new JsonResponse(['success' => false, 'message' => 'ID no proporcionado.'], JsonResponse::HTTP_BAD_REQUEST);
            }

            // Buscar el usuario por ID
            $postalServices = $postalServiceRepository->findBy(['postalProduct' => $id]);

            // Verificar si existen servicios postales
            if (!$postalServices) {
                return new JsonResponse(['success' => false, 'message' => 'Tipo de servicio no encontrado.'], JsonResponse::HTTP_NOT_FOUND);
            }

            $postalServiceData = array_map(function ($postalService) {
                return [
                    'id' => $postalService->getId(),
                    'name' => $postalService->getName(),
                ];
            }, $postalServices);



            return new JsonResponse(['success' => true, 'data' => $postalServiceData]);
        }
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
}
