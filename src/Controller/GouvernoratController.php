<?php

namespace App\Controller;

use App\Entity\Delegation;
use App\Entity\Gouvernorat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GouvernoratController extends AbstractController
{
    /**
     * @Route("/index", name="gouvernorat")
     */
    public function index(): Response
    {
        return $this->render('gouvernorat/index.html.twig', [
            'controller_name' => 'GouvernoratController',
        ]);
    }

    /**
     * @Route("/gouvernorat", name="read_gouvernorat")
     */
    public function Read(): Response
    {
        $liste_gouvernorat = $this->getDoctrine()->getRepository(Gouvernorat::class)
            ->findAll();
        return $this->render('gouvernorat/index.html.twig', [
            'controller_name' => 'GouvernoratController',
            'liste_gouvernorat' => $liste_gouvernorat
        ]);
    }


    /**
     * @Route("/gouvernorat/delegations/{id}", name="showdelegations")
     */
    public function delegations($id)
    {
        $gouvernorat = $this->getDoctrine()->getRepository(Gouvernorat::class)->find($id);
        $delegations = $this->getDoctrine()->getRepository(Delegation::class)->findBy(array('gouvernorat' => $gouvernorat->getId()));

        return $this->render('Gouvernorat/show.html.twig', [
            "gouvernorat" => $gouvernorat,
            "delegations" => $delegations
        ]);
    }


    /**
     * @Route("/gouvernorat/delegations/nbr/{id}", name="nbrdelegations")
     */
    public function nbrdel($id)
    {
        $gouvernorat = $this->getDoctrine()->getRepository(Gouvernorat::class)->find($id);
        $delegations = $this->getDoctrine()->getRepository(Delegation::class)->findBy(array('gouvernorat' => $gouvernorat->getId()));

        return $this->render('Gouvernorat/nombrdel.html.twig', [
            "gouvernorat" => $gouvernorat,
            "delegations" => $delegations
        ]);
    }
}
