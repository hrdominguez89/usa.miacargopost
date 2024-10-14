<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tracking')]
class TrackingController extends AbstractController
{
    #[Route('/', name: 'app_tracking_index')]
    public function index(): Response
    {
        $data['active'] = 'tracking';
        return $this->render('tracking/index.html.twig', $data);
    }
}
