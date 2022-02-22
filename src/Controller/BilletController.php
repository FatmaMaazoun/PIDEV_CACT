<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Form\BilletType;
use App\Repository\BilletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BilletController extends AbstractController
{
    /**
     * @Route("/billet", name="billet")
     */
    public function index(): Response
    {
        return $this->render('billet/index.html.twig', [
            'controller_name' => 'BilletController',
        ]);
    }
    /**
    /**
     * @param BilletRepository $Repository
     * @return \symfony\Component\HttpFoundation\Response
     * @Route ("/listbill", name="listbill")
     */

    public function affichebill(BilletRepository $Repository)
    {
        $billet= $Repository->findAll();
        return $this->render('billet/listebill.html.twig', [
            'billet' => $billet,
        ]);
    }
    /**
     * @param BilletRepository $Repository
     * @return \symfony\Component\HttpFoundation\Response
     * @return \symfony\Component\HttpFoundation\Request

     * @Route ("/deletebillet/{id}",name="deletebillet")
     */
    public function delete($id)
    {
        $em=$this->getDoctrine()->getManager();
        $billet=$em->getRepository(Billet::class)->find($id);
        $em->remove($billet);
        $em->flush();
        $response=new Response();
        $response->send();
        return $this->redirectToRoute('listbill');

    }
    /**
     * @Route("/newbillet", name="newbillet")
     */

    public function newbillet(Request $request )
    {   $billet = new Billet();
        $form = $this->createForm(BilletType::class, $billet);
        $form -> add ('Add.a.new.Billet', SubmitType::Class);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $reclamation = $form->getData();
            $em= $this->getDoctrine()->getManager();
            $em->persist ($reclamation);
            $em->flush();
            return $this->redirectToRoute('listbill');
        }
        return $this->render('billet/newbillet.html.twig', [
            'form_title'=>"Ajouter Une Billet",
            'form' => $form -> createView (),
        ]);
    }
    /**
     * @Route ("/updatebillet/{id}", name="updatebillet")
     */
    public function updatebillet(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $billet=$em->getRepository(Billet::class)->find($id);
        $form=$this->createForm(BilletType::class,$billet);
        $form->add('Update/Modifier',SubmitType::Class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('listref');
        }
        return $this->render('billet/updatebillet.html.twig',[
            'form_title'=>"Modifier Une Billet",
            'form'=>$form-> createView(),
        ]);
    }

}
