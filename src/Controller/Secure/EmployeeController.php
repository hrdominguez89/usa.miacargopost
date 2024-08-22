<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employee')]

class EmployeeController extends AbstractController
{
    #[Route('/{$status}', name: 'app_secure_employee')]
    public function index($status="employee"): Response
    {
        return $this->render('secure/employee/index.html.twig', [
            'controller_name' => 'EmployeeController',
            'active'=>'employee'
        ]);
    }
}
