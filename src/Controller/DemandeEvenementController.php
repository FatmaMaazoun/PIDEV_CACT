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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use DateTime;


class DemandeEvenementController extends AbstractController
{
    /**
     * @Route("/demande/evenement1", name="demande_evenement")
     */
    public function index(): Response
    {
        return $this->render('bodyHome.html.twig');
    }
    





    /**
     * @Route("/calendrier",name="calendrier")
     */
    public function calendrierEvenement()
    {
        $DemandeEvenementS = $this->getDoctrine()->getRepository(DemandeEvenement::class)->findAll();
        $DEs = [];
$allDay=true;

        foreach( $DemandeEvenementS as  $DemandeEvenement){
          
            $DEs[] = [
                'id' => $DemandeEvenement->getId(),
                'start' => $DemandeEvenement->getDateDebutEvent()->format('Y-m-d H:i:s'),
                'end' => $DemandeEvenement->getDateFinEvent()->format('Y-m-d H:i:s'),
                'title' => $DemandeEvenement->getDescriptionEvent(),
                'categorie'=>$DemandeEvenement->getDestination()->getSouscategorie()->getLibelle(),
              //  'description' => $DemandeEvenement->getDateDemande()->format('Y-m-d H:i:s'),
                'backgroundColor' =>$DemandeEvenement->getDestination()->getSouscategorie()->getCouleurEvenement()->getBackgrondColor(),
                'borderColor' =>$DemandeEvenement->getDestination()->getSouscategorie()->getCouleurEvenement()->getBorderColor(),
                'textColor' => $DemandeEvenement->getDestination()->getSouscategorie()->getCouleurEvenement()->getTextColor(),
                'allDay'=>$allDay,
              
            ];
        }

        $data = json_encode($DEs);
        //dump( $data);
        return $this->render('demande_evenement/calendrier1.html.twig', compact('data'));
        
    }
      






    /**
     * @Route("/api/{id}/edit", name="api_event_edit", methods={"PUT"})
     */
    public function majEvent(DemandeEvenement $calendar, Request $request)
    {
        // On récupère les données
        $donnees = json_decode($request->getContent());
        if(
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start)  
        ){
            // Les données sont complètes
            // On initialise un code
            $code = 200;
            // On vérifie si l'id existe
            if(!$calendar){
                // On instancie un rendez-vous
                $calendar = new DemandeEvenement;
                // On change le code
                $code = 201;
            }
            // On hydrate l'objet avec les données
            $calendar->setDescriptionEvent($donnees->title); 
            $calendar->setDateDebutEvent(new DateTime($donnees->start));
            $calendar->setDateFinEvent(new DateTime($donnees->start));
           

            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();
            // On retourne le code
            return new Response('Ok', $code);
             }else{
            // Les données sont incomplètes
            return new Response('Données incomplètes', 404);
            }     
    }







  /**
     * @Route("/demande/evenement/update/{id}", name="updateDemandeEvenement")
     */
    public function updateDemandeEvenement(Request $request, $id,DemandeEvenement $demandeEvenement)
    {
        $DemandeEvenement = $this->getDoctrine()->getRepository(DemandeEvenement::class)->find($id);
        $DemandeEvenementId=$DemandeEvenement->getId();
        $form = $this->createForm(DemandeEvenementType::class, $DemandeEvenement);
       // $form->add("Accepter", SubmitType::class);
    //   $form->add("Refuser", SubmitType::class);
       $form->add('statut',null, [
            'required'   => false,
           'empty_data' => 'Accepter',
       ]);
        $form->handleRequest($request);
         // On récupère les données
         $donnees = $request->getContent();
        if ($form->isSubmitted()&& $form->isValid())
         {    
         $clicked = $request->request->get('clicked');
            if($clicked === 'Refuser'){
                if(!$demandeEvenement){
                    $file = $form->get('image')->getData();
                
                    $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                  //  $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                 
                  // moves the file to the directory where brochures are stored
                  $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName
                );
        
                $demandeEvenement->setImage($fileName);
                    // On instancie un rendez-vous
                    $demandeEvenement = new DemandeEvenement;
                    // On change le code
                    $code = 201;
                }
                // On hydrate l'objet avec les données
                $demandeEvenement->setStatut("Refuser"); 
            
               
                $em = $this->getDoctrine()->getManager();
                $em->persist($demandeEvenement);
                $em->flush();
    
                return $this->redirectToRoute('DemandeEvenementRefuser');
            }
        
            if($clicked === 'Accepter'){
                if(!$demandeEvenement){
                    $file = $form->get('image')->getData();
                
                    $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                  //  $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                 
                  // moves the file to the directory where brochures are stored
                  $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName
                );
        
                $demandeEvenement->setImage($fileName);
                    // On instancie un rendez-vous
                    $demandeEvenement = new DemandeEvenement;
                    // On change le code
                    $code = 201;
                }
                // On hydrate l'objet avec les données
                $demandeEvenement->setStatut("Accepter"); 
            $em = $this->getDoctrine()->getManager();
            $em->persist($demandeEvenement);
            $em->flush();
            return $this->redirectToRoute('DemandeEvenementAccepter');
            }

          
}
        return $this->render("demande_evenement/update.html.twig", array('form' => $form->createView(),'DemandeEvenement' =>$DemandeEvenementId));
    }

/**
     * @Route("/demande/evenement/Affiche/front",name="AfficheFront")
     */
    public function showDemandeEvenementFront()
    {
        $DemandeEvenement = $this->getDoctrine()->getRepository(DemandeEvenement::class)->findAll();
        //$DemandeEvenement = $this->getDoctrine()->getRepository(DemandeEvenement::class)->listDemandeEvenementAccepter();
        return $this->render('bodyHome.html.twig', ["listDemandeEvenement" => $DemandeEvenement]);
    }


  
    /**
     * @Route("/demande/evenement/Affiche",name="Affiche")
     */
    public function showDemandeEvenement()
    {
        $DemandeEvenement = $this->getDoctrine()->getRepository(DemandeEvenement::class)->findAll();
        return $this->render('demande_evenement/index.html.twig', ["listDemandeEvenement" => $DemandeEvenement]);
    }

    /**
     * @Route("/demande/evenement/Affiche/{id}", name="i")
     */
    public function showDemandeEvenementById($id)
    {
        $DemandeEvenementById = $this->getDoctrine()->getRepository(DemandeEvenement::class)->find($id);

        return $this->render('demande_evenement/evenement.html.twig', ["listDemandeEvenementById" => $DemandeEvenementById]);
    }



    
    
    /**
     * @Route("/DemandeEvenementEnAttente", name="DemandeEvenementEnAttente")
     */
    public function listDemandeEvenementEnAttente()
    {

        $demandeEvenementEnAttente=$this->getDoctrine()->getRepository(DemandeEvenement::class)->listDemandeEvenementEnAttente();
        
        return $this->render('demande_evenement/listDemandeEvenementEnAttente.html.twig', [
            "demandeEvenementEnAttente" =>$demandeEvenementEnAttente,
        ]);
    }



     /**
     * @Route("/DemandeEvenementAccepter", name="DemandeEvenementAccepter")
     */
    public function listDemandeEvenementAccepter(DemandeEvenementRepository $repo)
    {

        $listDemandeEvenementAccepter = $repo->listDemandeEvenementAccepter();

        //orderByDate();
        return $this->render('demande_evenement/listDemandeEvenementAccepter.html.twig', [
            "listDemandeEvenementAccepter" => $listDemandeEvenementAccepter,
        ]);
    }



     /**
     * @Route("/DemandeEvenementRefuser", name="DemandeEvenementRefuser")
     */
    public function listDemandeEvenementRefuser(DemandeEvenementRepository $repo)
    {

        $listDemandeEvenementRefuser = $repo->listDemandeEvenementRefuser();

        //orderByDate();
        return $this->render('demande_evenement/listDemandeEvenementRefuser.html.twig', [
            "listDemandeEvenementRefuser" => $listDemandeEvenementRefuser,
        ]);
    }
    
    


 /**
     * @Route("/listEvenementAccepterDateDans2Semaine", name="listEvenementAccepterDateDans2Semaine")
     */
    public function listEvenementAccepterDateDans2Semaine(DemandeEvenementRepository $repo)
    {

        $listEvenementAccepterDateDans2Semaine = $repo->listEvenementAccepterDateDans2Semaine();

        //orderByDate();
        return $this->render('demande_evenement/listEvenementAccepterDateDans2Semaine.html.twig', [
            "listEvenementAccepterDateDans2Semaine" => $listEvenementAccepterDateDans2Semaine,
        ]);
    }








   
    /**
     * @Route("/demande/evenement/add", name="addDemandeEvenement1")
     */
    public function addDemandeEvenement(Request $request)
    {  
        $demandeEvenement = new DemandeEvenement();
        $form = $this->createForm(DemandeEvenementType::class, $demandeEvenement);
      //  $form->add("Ajouter", SubmitType::class);
        $form->add('statut',null, [
            'required'   => false,
            'empty_data' => 'en attente',
        ]);
         $form->handleRequest($request);
         $clicked = $request->request->get('clicked');
        if ($form->isSubmitted()&& $form->isvalid()) {   
            if($clicked === 'Ajouter'){
            
                $file = $form->get('image')->getData();
                
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
          //  $fileName = md5(uniqid()) . '.' . $file->guessExtension();
         
          // moves the file to the directory where brochures are stored
          $file->move(
            $this->getParameter('brochures_directory'),
            $fileName
        );

        $demandeEvenement->setImage($fileName);
         
      /*    try {
                $file->move(
                    $this->getParameter('img_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            */ 
            $em = $this->getDoctrine()->getManager();
            $em->persist($demandeEvenement);
            $em->flush();
            $idDemendeEvenement=$demandeEvenement->getId();
            return $this->redirectToRoute('updateDemandeEvenementAjouterCoutEvenement',array('id'=>$idDemendeEvenement));
        }}
        return $this->render("demande_evenement/add.html.twig", array('form' => $form->createView()));
    }




  /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }


  /**
     * @Route("/demandeevenementAjouterCoutEvenement/update/{id}", name="updateDemandeEvenementAjouterCoutEvenement")
     */
    public function updateDemandeEvenementAjouterCoutEvenement(Request $request, $id,DemandeEvenement $demandeEvenement)
    {
        $DemandeEvenement = $this->getDoctrine()->getRepository(DemandeEvenement::class)->find($id);
        $DemandeEvenementId=$DemandeEvenement->getId();
        $form = $this->createForm(DemandeEvenementType::class, $DemandeEvenement);
       // $form->add("Accepter", SubmitType::class);
    //   $form->add("Refuser", SubmitType::class);
       $form->add('statut',null, [
            'required'   => false,
           'empty_data' => 'Accepter',
       ]);
        $form->handleRequest($request);
         // On récupère les données
         $donnees = $request->getContent();
        if ($form->isSubmitted()&& $form->isValid())
         {    
        
                    $demandeEvenement = new DemandeEvenement;
                    // On change le code
                $em = $this->getDoctrine()->getManager();
                $em->persist($demandeEvenement);
                $em->flush();
    
               // return $this->redirectToRoute('DemandeEvenementRefuser');
            }
    

        return $this->render("demande_evenement/updateDemandeEvenementAjouterCoutEvenement.html.twig", array('form' => $form->createView(),'DemandeEvenement' =>$DemandeEvenementId));
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
        return $this->redirectToRoute("DemandeEvenementEnAttente");
    }
    
    /**
     * @Route("/demande/evenement/delete/Refuser/{id}", name="deleteDemandeEvenementRefuser")
     */
    public function deleteDemandeEvenementRefuser($id)
    {
        $DemandeEvenement = $this->getDoctrine()->getRepository(DemandeEvenement::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($DemandeEvenement);
        $em->flush();
        return $this->redirectToRoute("DemandeEvenementRefuser");
    }



 /**
     * @Route("/demande/evenement/delete/Accepter/{id}", name="deleteDemandeEvenementAccepter")
     */
    public function deleteDemandeEvenementAccepter($id)
    {
        $DemandeEvenement = $this->getDoctrine()->getRepository(DemandeEvenement::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($DemandeEvenement);
        $em->flush();
        return $this->redirectToRoute("DemandeEvenementAccepter");
    }






  



/**
     * @Route("/demande/evenement/update/Accepter/{id}", name="updateDemandeEvenementAccepter")
     */
    public function updateDemandeEvenementAccepter(Request $request, $id)
    {
        $DemandeEvenement = $this->getDoctrine()->getRepository(DemandeEvenement::class)->find($id);
        $form = $this->createForm(DemandeEvenementType::class, $DemandeEvenement);
       
        $form->add('statut',null, [
            'required'   => false,
            'empty_data' => 'Accepter',
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()&& $form->isValid()) {
           
         $clicked = $request->request->get('clicked');
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('DemandeEvenementAccepter');
            }

        return $this->render("demande_evenement/updateDemandeEvenementAccepter.html.twig", array('form' => $form->createView()));
    }











/**
     * @Route("/demande/evenement/update/Refuser/{id}", name="updateDemandeEvenementRefuser")
     */
    public function updateDemandeEvenementRefuser(Request $request, $id)
    {
        $DemandeEvenement = $this->getDoctrine()->getRepository(DemandeEvenement::class)->find($id);
        $form = $this->createForm(DemandeEvenementType::class, $DemandeEvenement);
       
        $form->add('statut',null, [
            'required'   => false,
            'empty_data' => 'Accepter',
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()&& $form->isValid()) {
           
         $clicked = $request->request->get('clicked');
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('DemandeEvenementRefuser');
            }

        return $this->render("demande_evenement/updateDemandeEvenementRefuser.html.twig", array('form' => $form->createView()));
    }








    



    


 





     /**
     * @Route("/get/DemandeEvenement",name="getDemandeEvenement1")
     */
    public function getlistDemandeEvenement(DemandeEvenementRepository $repo,NormalizerInterface $Normalizer)
    {
        $demandeEvenement = $repo->findAll();
        //dump($user);
        $json=$Normalizer->normalize($demandeEvenement,'json',['groups'=>'demandeEvenement']);
      
       return new Response(json_encode($json));
  
        
       
    }

     /**
     * @Route("/add/DemandeEvenement",name="addDemandeEvenementMobile")
     */
    public function addlistDemandeEvenement(Request $request,DemandeEvenementRepository $repo,SerializerInterface $serializerInterface)
    {
        $em = $this->getDoctrine()->getManager();
        $demandeEvenement = new DemandeEvenement();
        $demandeEvenement->setDateDemande($request->get('date_demande'));
        $demandeEvenement->setStatus($request->get('statut'));
        $demandeEvenement->setDescriptionDemande($request->get('description_demande'));
        $demandeEvenement->setDateDebutEvent($request->get('date_debutEvent'));
        $demandeEvenement->setDateFinEvent($request->get('date_finEvent'));
        $demandeEvenement->setHeureDebutEvent($request->get('heure_debutEvent'));
        $demandeEvenement->setHeureFinEvent($request->get('heure_finEvent'));
        $demandeEvenement->setDescriptionEvent($request->get('description_event'));
        $demandeEvenement->setCpacite($request->get('capacite'));
     
        $em->persist($demandeEvenement);
        $em->flush();
        $json=$Normalizer->normalize($demandeEvenement,'json',['groups'=>'demandeEvenement']);
      
        return new Response(json_encode($json));
   
       
    }



}
