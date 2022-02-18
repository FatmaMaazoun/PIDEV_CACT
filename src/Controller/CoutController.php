<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoutController extends AbstractController
{
    /**
     * @Route("/cout", name="cout")
     */
    public function index(): Response
    {
        return $this->render('cout/index.html.twig', [
            'controller_name' => 'CoutController',
        ]);
    }
}
