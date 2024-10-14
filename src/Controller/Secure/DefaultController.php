<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/index', name: 'app_default_index', methods: ['GET'])]
    #[Cache(smaxage: 10)]
    public function index(): Response
    {
        dd('aca');
        return $this->render('default/index.html.twig', ['active' => 'home']);
    }
}
