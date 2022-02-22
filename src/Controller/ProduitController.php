<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Media;
use App\Entity\Produit;
use App\Form\AvisType;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(): Response
    {
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }

    /**
     * @Route("/prodaff", name="produit_affiche", methods={"GET"})
     */
    public function Affiche()
    {
        $produit = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        return $this->render('produit/listeproduit.html.twig', [
            'produi' => $produit]);
    }

    /**
     * @Route("/addprod", name="prod_add", methods={"GET", "POST"})
     */
    public function Add(Request $request): Response
{
    $produi = new Produit();
    $em = $this->getDoctrine()->getManager();
    $form = $this->createForm(ProduitType::class, $produi);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($produi);
        $em->flush();
        return $this->redirectToRoute('produit_affiche');
    }
    return $this->render('produit/add.html.twig', [
        'produi' => $produi,
        'form' => $form->createView(),
    ]);
}

    /**
     * @Route("/deleteprod/{id}", name="prod_delete",requirements={"id":"\d+"})
     */
    public function delete($id)
    {

        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('produit_affiche');
    }

    /**
     * @Route("/update/{id}", name="prod_update", methods={"GET", "POST"})
     */
    public function update(Request $request, $id)
    {
        $produit = new Produit();
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('produit_affiche');
        }
        return $this->render('produit/update.html.twig', [
            'form' => $form->createView(),
        ]);

    }


}





