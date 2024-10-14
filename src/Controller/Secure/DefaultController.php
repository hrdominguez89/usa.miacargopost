<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/index')]
class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default_index', methods: ['GET'])]
    #[Cache(smaxage: 10)]
    public function index(): Response
    {
        $data['active'] = 'home';
        return $this->render('secure/default/index.html.twig', $data);
    }
}
