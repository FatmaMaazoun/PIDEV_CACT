<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use SebastianBergmann\Environment\Console;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response as FlexResponse;

class CategorieController extends AbstractController
{
    /**
     * @Route("/index", name="categorie")
     */
    public function index()
    {

        return new Response("hello");
    }


    /**
     * @Route("/categorie", name="read_categorie")
     */
    public function Read(): Response
    {
        $liste_categorie = $this->getDoctrine()->getRepository(Categorie::class)
            ->findAll();
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'liste_categorie' => $liste_categorie

        ]);
    }

    /**
     * @Route("/categorie/ajouter", name="create_categorie")
     */
    public function create(Request $request): Response
    {
        //$foo = $request->get('libelle');

        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->add('save', SubmitType::class, ['label' => 'Enregistrer']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();


            return $this->redirectToRoute('read_categorie');
        } else {
            return $this->render('categorie/addcategorie.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/categorie/supp/{id}", name="delete_categorie")
     */
    public function delete($id)
    {

        $obj = $this->getDoctrine()->getRepository(Categorie::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('read_categorie');
    }


    /**
     * @Route("/categorie/modif/{id}", name="Update_categorie")
     */
    public function Update(Request $request, $id)
    { //chercher object a modifier

        $obj = $this->getDoctrine()->getRepository(Categorie::class)->find($id);
        $form = $this->createForm(CategorieType::class, $obj);
        $form->add(
            'Update',
            SubmitType::class,
            ['label' => 'Modifier']
        );
        $form->handleRequest($request);
        if (($form->isSubmitted()) && ($form->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('read_categorie');
        } else {
            return $this->render(
                'categorie/editcategorie.html.twig',
                ['form' => $form->createView()]
            );
        }
    }
}
