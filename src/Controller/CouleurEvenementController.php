<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CouleurEvenementController extends AbstractController
{
    /**
     * @Route("/couleur/evenement", name="couleur_evenement")
     */
    public function index(): Response
    {
        return $this->render('couleur_evenement/index.html.twig', [
            'controller_name' => 'CouleurEvenementController',
        ]);
    }



    }







