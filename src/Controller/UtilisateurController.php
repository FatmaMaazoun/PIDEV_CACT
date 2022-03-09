<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    /**
     * @Route("/listutilisateurs",name="listutilisateurs")
     */
    public function listUtilisateurs()
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        return $this->render('utilisateur/list.html.twig', ["utilisateurs" => $user]);
    }
    

    /**
     * @Route("/addutilisateur",name="addutilisateurs")
     */
    public function addUtilisateur(Request $request)
    {
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('listutilisateurs');
        }
        return $this->render("utilisateur/add.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/editutilisateur/{id}",name="edit_utilisateurs")
     *Method({"GET","POST"})
     */
    public function editUtilisateur(Request $request, $id)
    {
        $user = new Utilisateur();
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('listutilisateurs');
        }
        return $this->render('utilisateur/edit.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/deleteutilisateur/{id}",name="deleteutilisateur")
     */
    public function deleteUtilisateur($id)
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('listutilisateurs');
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






     /**
     * @Route("/get/listutilisateurs",name="getlistutilisateurs")
     */
    public function getlistUtilisateurs(UtilisateurRepository $repo,SerializerInterface $serializerInterface)
    {
        $user = $repo->findAll();
        //dump($user);
        $json=$serializerInterface->serialize($user,'json',['groups'=>'utilisateur']);
      
       return new Response(json_encode($json));
  
        
       
    }

}
