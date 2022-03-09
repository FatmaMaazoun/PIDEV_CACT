<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\EntityManagerInterface;

class AvisController extends AbstractController
{
    /**
     * @Route("/avis", name="avis")
     */
    public function index(): Response
    {
        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
        ]);
    }

    /**
     * @Route("/avi/Affiche", name="avis_affiche", methods={"GET"})
     */
    public function Affiche()
    {
        $avis = $this->getDoctrine()->getRepository(Avis::class)->findAll();
        return $this->render('avis/listeavis.html.twig', [
            'avis' => $avis
        ]);
    }


    /**
     * @Route("/delete", name="avis_delete", methods={"POST"})
     */
    public function delete(Request $request, $id, Avis $avis): Response
    {
        $avis = $this->getDoctrine()->getRepository(Avis::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($avis);
        $em->flush();
        return $this->redirectToRoute('avis_listeavis');
    }

    /**
     * @Route("/ajouteavis", name="avis_add")
     */
    public function Add(Request $request): Response
    {
        $avi = new Avis();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($avi);
            $em->flush();
            return $this->redirectToRoute('avis_affiche');
        }
        return $this->render('avis/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update", name="avis_update", methods={"GET", "POST"})
     */
    public function update(Request $request): Response
    {
        $avi = new Avis();
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('avis_affiche');
        }

        return $this->render('avis/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/demande/evenement1", name="demande_evenement")
     */
    public function index1(): Response
    {
        return $this->render('front.html.twig', [
            'controller_name' => 'DemandeEvenementController',
        ]);
    }
}
