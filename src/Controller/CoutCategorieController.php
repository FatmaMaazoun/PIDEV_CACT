<?php

namespace App\Controller;

use App\Entity\CoutCategorie;
use App\Form\CoutCategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CoutCategorieRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;


class CoutCategorieController extends AbstractController
{
    /**
     * @Route("/index", name="cout_categorie")
     */
    public function index(): Response
    {
        return $this->render('cout_categorie/index.html.twig', [
            'controller_name' => 'CoutCategorieController',
        ]);
    }


    /**
     * @Route("/cout/categorie/categories", name="read_cout_categorie")
     */
    public function Read(): Response
    {
        $coutscat = $this->getDoctrine()->getRepository(CoutCategorie::class)
            ->findAll();
        return $this->render('cout_categorie/index.html.twig', [
            'controller_name' => 'CoutCategorieController',
            'coutscat' => $coutscat
        ]);
    }


    /**
     * @Route("/cout/categorie/ajouter", name="create_coutcategorie")
     */
    public function create(Request $request): Response
    {
        $coutcategorie = new CoutCategorie();
        $form = $this->createForm(CoutCategorieType::class, $coutcategorie);
        $form->add('save', SubmitType::class, ['label' => 'Enregistrer']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($coutcategorie);
            $em->flush();


            return $this->redirectToRoute('read_cout_categorie');
        } else {
            return $this->render('cout_categorie/addcoutcategorie.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/cout/categorie/supp/{id}", name="delete_coutcategorie")
     */
    public function delete($id)
    {

        $obj = $this->getDoctrine()->getRepository(CoutCategorie::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('read_cout_categorie');
    }


    /**
     * @Route("/cout/categorie/modif/{id}", name="Update_coutcategorie")
     */
    public function Update(Request $request, $id)
    { //chercher object a modifier

        $obj = $this->getDoctrine()->getRepository(CoutCategorie::class)->find($id);
        $form = $this->createForm(CoutCategorieType::class, $obj);
        $form->add(
            'update',
            SubmitType::class,
            ['label' => 'Modifier']
        );
        $form->handleRequest($request);
        if (($form->isSubmitted()) && ($form->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('read_cout_categorie');
        } else {
            return $this->render(
                'cout_categorie/editcoutcategorie.html.twig',
                ['form' => $form->createView()]
            );
        }
    }
}
