<?php

namespace App\Controller;

use App\Entity\SousCategorie;
use App\Form\SousCategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SousCategorieController extends AbstractController
{
    /**
     * @Route("/index", name="sous_categorie")
     */
    public function index(): Response
    {
        return $this->render('sous_categorie/index.html.twig', [
            'controller_name' => 'SousCategorieController',
        ]);
    }

    /**
     * @Route("/souscategorie", name="read_souscategorie")
     */
    public function Read(): Response
    {
        $liste_souscategorie = $this->getDoctrine()->getRepository(SousCategorie::class)
            ->findAll();
        return $this->render('sous_categorie/index.html.twig', [

            'liste_souscategorie' => $liste_souscategorie

        ]);
    }


    /**
     * @Route("/souscategorie/ajouter", name="create_souscategorie")
     */
    public function create(Request $request): Response
    {


        $souscategorie = new SousCategorie();
        $form = $this->createForm(SousCategorieType::class, $souscategorie);
        $form->add('save', SubmitType::class, ['label' => 'Enregistrer']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($souscategorie);
            $em->flush();
            return $this->redirectToRoute('read_souscategorie');
        } else {
            return $this->render('sous_categorie/addsouscategorie.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/souscategorie/supp/{id}", name="delete_souscategorie")
     */
    public function delete($id)
    {

        $obj = $this->getDoctrine()->getRepository(SousCategorie::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('read_souscategorie');
    }




    /**
     * @Route("/souscategorie/modif/{id}", name="update_souscategorie")
     */
    public function Update(Request $request, $id)
    { //chercher object a modifier

        $obj = $this->getDoctrine()->getRepository(SousCategorie::class)->find($id);
        $form = $this->createForm(SousCategorieType::class, $obj);
        $form->add(
            'Update',
            SubmitType::class,
            ['label' => 'Modifier']
        );
        $form->handleRequest($request);
        if (($form->isSubmitted()) && ($form->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('read_souscategorie');
        } else {
            return $this->render(
                'sous_categorie/editsouscategorie.html.twig',
                ['form' => $form->createView()]
            );
        }
    }
}
