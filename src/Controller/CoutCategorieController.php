<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoutCategorieController extends AbstractController
{
    /**
     * @Route("/cout/categorie", name="cout_categorie")
     */
    public function index(): Response
    {
        return $this->render('cout_categorie/index.html.twig', [
            'controller_name' => 'CoutCategorieController',
        ]);
    }
}
