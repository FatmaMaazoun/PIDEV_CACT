<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeEvenementController extends AbstractController
{
    /**
     * @Route("/demande/evenement", name="demande_evenement")
     */
    public function index(): Response
    {
        return $this->render('demande_evenement/index.html.twig', [
            'controller_name' => 'DemandeEvenementController',
        ]);
    }
}
