<?php

namespace App\Controller;

use App\Entity\CoutEvenement;
use App\Form\CoutEvenementType;
use App\Repository\CoutEvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;



class CoutEvenementController extends AbstractController
{
    /**
     * @Route("/cout/evenement", name="cout_evenement")
     */
    public function index(): Response
    {
        return $this->render('cout_evenement/index.html.twig', [
            'controller_name' => 'CoutEvenementController',
        ]);
    }


    /**
     * @Route("/coutEvenement/Affiche", name="AfficheCoutEvenement")
     */
    public function showCoutEvenement()
    {
        $CoutEvenement = $this->getDoctrine()->getRepository(CoutEvenement::class)->findAll();
        return $this->render('cout_evenement/index.html.twig', ["listCoutEvenement" => $CoutEvenement]);
    }

 /**
     * @Route("/coutEvenement/Affiche/{id}", name="AfficheCoutEvenementByIdDemandeEvenement")
     */
    public function showlistCoutEvenementByIdDemandeEvenement($id)
    {
       
        $CoutEvenementByIdDemandeEvenement =$this->getDoctrine()->getRepository(CoutEvenement::class)->listCoutEvenementByIdDemandeEvenement($id);
        return $this->render('cout_evenement/index.html.twig', ["listCoutEvenement" => $CoutEvenementByIdDemandeEvenement]);
    }



    /**
     * @Route("/coutEvenement/add/{id}", name="addCoutEvenement")
     */
    public function addCoutEvenement(Request $request,$id)
    {
        $CoutEvenementByIdDemandeEvenement =$this->getDoctrine()->getRepository(CoutEvenement::class)->listCoutEvenementByIdDemandeEvenement($id);
        $CoutEvenement = new CoutEvenement();
        $form = $this->createForm(CoutEvenementType::class, $CoutEvenement);
       
        $form->handleRequest($request);
        $clicked = $request->request->get('clicked');
        if ($form->isSubmitted()&& $form->isvalid()) {
            if($clicked === 'Ajouter'){
            $CoutEvenement->setDemandeEvent($id); 
            $em = $this->getDoctrine()->getManager();
            $em->persist($CoutEvenement);
         //   dd($CoutEvenement);
            $em->flush(); 
            }
        }
        return $this->render("cout_evenement/add.html.twig", array('form' => $form->createView(),'listCoutEvenement' =>$CoutEvenementByIdDemandeEvenement,'id' =>$id));
    }








    /**
     * @Route("/coutEvenement/delete/{id}", name="deleteCoutEvenement")
     */
    public function deleteCoutEvenement($id)
    {
        $CoutEvenement = $this->getDoctrine()->getRepository(CoutEvenement::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($CoutEvenement);
        $em->flush();
        $this->addFlash(
            'info',
            'Delet Successfully');
        return $this->redirectToRoute("AfficheCoutEvenement");
    }
    /**
     * @Route("/coutEvenement/update/{id}", name="updateCoutEvenement")
     */
    public function updateCoutEvenement(Request $request, $id)
    {
        $CoutEvenement = $this->getDoctrine()->getRepository(CoutEvenement::class)->find($id);
        $form = $this->createForm(CoutEvenementType::class, $CoutEvenement);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheCoutEvenement');
        }
        return $this->render("cout_evenement/update.html.twig", array('form' => $form->createView()));
    }
}
