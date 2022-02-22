<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="reclamation")
     */
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    /**
    /**
     * @param ReclamationRepository $Repository
     * @return \symfony\Component\HttpFoundation\Response
     * @Route ("/listrec", name="listrec")
     */

    public function afficherec(ReclamationRepository $Repository)
    {
        $reclamation= $Repository->findAll();
        return $this->render('reclamation/listerec.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }
    /**
     * @param ReclamationRepository $Repository
     * @return \symfony\Component\HttpFoundation\Response
     * @return \symfony\Component\HttpFoundation\Request

     * @Route ("/deletereclamation/{id}",name="deletereclamation")
     */
    public function delete($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        $response=new Response();
        $response->send();
        return $this->redirectToRoute('listrec');

    }
    /**
     * @Route("/newreclamation", name="newreclamation")
     */

    public function newreseclamation(Request $request )
    {   $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form -> add ('Add.a.new.Reclamation', SubmitType::Class);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $reclamation = $form->getData();
            $em= $this->getDoctrine()->getManager();
            $em->persist ($reclamation);
            $em->flush();
            return $this->redirectToRoute('listrec');
        }
        return $this->render('reclamation/newreclamation.html.twig', [
            'form_title'=>"Ajouter Une Reclamation",
            'form' => $form -> createView (),
        ]);
    }
    /**
     * @Route ("/updatereclamation/{id}", name="updatereclamation")
     */
    public function updatereclamation(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $form=$this->createForm(ReclamationType::class,$reclamation);
        $form->add('Update/Modifier',SubmitType::Class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('listrec');
        }
        return $this->render('reclamation/updatereclamation.html.twig',[
            'form_title'=>"Modifier Une Reclamation",
            'form'=>$form-> createView(),
        ]);
    }
}
