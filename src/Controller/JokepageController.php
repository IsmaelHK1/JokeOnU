<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JokepageController extends AbstractController
{
    #[Route('/jokepage', name: 'app_jokepage')]
    public function index(): Response
    {
        return $this->render('jokepage/index.html.twig', [
            'controller_name' => 'JokepageController',
        ]);
    }
}
