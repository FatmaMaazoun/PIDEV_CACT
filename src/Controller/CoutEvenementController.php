<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoutEvenementController extends AbstractController
{
    /**
     * @Route("/cout/evenement", name="cout_evenement")
     */
    public function index(): Response
    {
        return $this->render('cout_evenement/index.html.twig', [
            'controller_name' => 'CoutEvenementController',
        ]);
    }
}
