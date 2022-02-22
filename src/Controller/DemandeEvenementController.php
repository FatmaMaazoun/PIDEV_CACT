<?php

namespace App\Controller;
use App\Entity\DemandeEvenement;
use App\Entity\Destination;
use App\Form\DemandeEvenementType;
use App\Repository\DemandeEvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
class DemandeEvenementController extends AbstractController
{
    /**
     * @Route("/demande/evenement", name="demande_evenement")
     */
    public function index(): Response
    {
        return $this->render('demande_evenement/index.html.twig', [
            'controller_name' => 'DemandeEvenementController',
        ]);
    }
   
     /**
     * @Route("/demande/evenement/Affiche",name="Affiche")
     */
    public function showDemandeEvenement(){
        $DemandeEvenement=$this->getDoctrine()->getRepository(DemandeEvenement :: class)->findAll();
        return $this->render('demande_evenement/index.html.twig',["listDemandeEvenement"=>$DemandeEvenement]);
    }
    
   /**
     * @Route("/demande/evenement/Affiche/{id}", name="i")
     */
    public function showDemandeEvenementById($id)
    {
        $DemandeEvenementById = $this->getDoctrine()->getRepository(DemandeEvenement::class)->find($id);
   
    return $this->render('demande_evenement/evenement.html.twig',["listDemandeEvenementById"=>$DemandeEvenementById]);
}

   /**
     * @Route("/demande/evenement/add", name="addDemandeEvenement")
     */
    public function addDemandeEvenement(Request $request)
    {
        $demandeEvenement = new DemandeEvenement();
        $form = $this->createForm(DemandeEvenementType::class, $demandeEvenement);
        $form->add("Ajouter", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($demandeEvenement);
            $em->flush();
            return $this->redirectToRoute('Affiche');
        }
        return $this->render("demande_evenement/add.html.twig", array('form' => $form->createView()));
    }


      /**
     * @Route("/demande/evenement/delete/{id}", name="deleteDemandeEvenement")
     */
    public function deleteDemandeEvenement($id)
    {
        $DemandeEvenement = $this->getDoctrine()->getRepository(DemandeEvenement::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($DemandeEvenement);
        $em->flush();
        return $this->redirectToRoute("Affiche");
    }
 /**
     * @Route("/demande/evenement/update/{id}", name="updateDemandeEvenement")
     */
    public function updateDemandeEvenement(Request $request, $id)
    {
        $DemandeEvenement = $this->getDoctrine()->getRepository(DemandeEvenement::class)->find($id);
        $form = $this->createForm(DemandeEvenementType::class, $DemandeEvenement);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('Affiche');
        }
        return $this->render("demande_evenement/update.html.twig", array('form' => $form->createView()));
    }

    

}