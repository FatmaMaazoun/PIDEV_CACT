<?php

namespace App\Controller;

use App\Entity\Cout;
use App\Form\CoutType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoutController extends AbstractController
{
    /**
     * @Route("/index", name="cout")
     */
    public function index(): Response
    {
        return $this->render('cout/index.html.twig', [
            'controller_name' => 'CoutController',
        ]);
    }

    /**
     * @Route("/couts", name="read_cout")
     */
    public function Read(): Response
    {
        $liste_cout = $this->getDoctrine()->getRepository(Cout::class)
            ->findAll();
        return $this->render('cout/index.html.twig', [
            'liste_cout' => $liste_cout

        ]);
    }

    /**
     * @Route("/cout/ajouter", name="create_cout")
     */
    public function create(Request $request): Response
    {
        //$foo = $request->get('libelle');

        $cout = new Cout();
        $form = $this->createForm(CoutType::class, $cout);
        $form->add('save', SubmitType::class, ['label' => 'Enregistrer']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($cout);
            $em->flush();


            return $this->redirectToRoute('read_cout');
        } else {
            return $this->render('cout/addcout.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }



    /**
     * @Route("/cout/supp/{id}", name="delete_cout")
     */
    public function delete($id)
    {

        $obj = $this->getDoctrine()->getRepository(Cout::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('read_cout');
    }


    /**
     * @Route("/cout/modif/{id}", name="update_cout")
     */
    public function Update(Request $request, $id)
    { //chercher object a modifier

        $obj = $this->getDoctrine()->getRepository(Cout::class)->find($id);
        $form = $this->createForm(CoutType::class, $obj);
        $form->add(
            'Update',
            SubmitType::class,
            ['label' => 'Modifier']
        );
        $form->handleRequest($request);
        if (($form->isSubmitted()) && ($form->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('read_cout');
        } else {
            return $this->render(
                'cout/editcout.html.twig',
                ['form' => $form->createView()]
            );
        }
    }
}
