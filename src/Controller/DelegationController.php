<?php

namespace App\Controller;

use App\Entity\Delegation;
use App\Form\DelegationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DelegationController extends AbstractController
{
    /**
     * @Route("/index", name="delegation")
     */
    public function index(): Response
    {
        return $this->render('delegation/index.html.twig', [
            'controller_name' => 'DelegationController',
        ]);
    }

    /**
     * @Route("/delegation", name="read_delegation")
     */
    public function Read(): Response
    {
        $liste_delegations = $this->getDoctrine()->getRepository(Delegation::class)
            ->findAll();
        return $this->render('delegation/index.html.twig', [
            'controller_name' => 'DelegationController',
            'liste_delegations' => $liste_delegations

        ]);
    }


    /**
     * @Route("/delejouter", name="create_del")
     */
    public function create(Request $request): Response
    {

        $del = new Delegation();
        $form = $this->createForm(DelegationType::class, $del);
        $form->add('save', SubmitType::class, ['label' => 'Enregistrer']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($del);
            $em->flush();


            return $this->redirectToRoute('read_delegation');
        } else {
            return $this->render('delegation/adddelegation.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/delegation/supp/{id}", name="delete_delegation")
     */
    public function delete($id)
    {

        $obj = $this->getDoctrine()->getRepository(Delegation::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('read_delegation');
    }


    /**
     * @Route("/delegation/modif/{id}", name="update_delegation")
     */
    public function Update(Request $request, $id)
    { //chercher object a modifier

        $obj = $this->getDoctrine()->getRepository(Delegation::class)->find($id);
        $form = $this->createForm(DelegationType::class, $obj);
        $form->add(
            'Update',
            SubmitType::class,
            ['label' => 'Modifier']
        );
        $form->handleRequest($request);
        if (($form->isSubmitted()) && ($form->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('read_delegation');
        } else {
            return $this->render(
                'delegation/editdelegation.html.twig',
                ['form' => $form->createView()]
            );
        }
    }
}
