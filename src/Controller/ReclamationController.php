<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

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
     * /**
     * @param ReclamationRepository $Repository
     * @return \symfony\Component\HttpFoundation\Response
     * @Route ("/listrec", name="listrec")
     */

    public function afficherec(ReclamationRepository $Repository,Request $request,PaginatorInterface $paginator)
    {
        $reclamation = $Repository->findAll();
        $reclamation = $paginator->paginate(
            $reclamation,
            $request->query->getInt('page',1) ,
            3
        ) ;
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
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        $this->addFlash(
            'info',
            'Deleted Successfully'
        );
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('listrec');
    }

    /**
     * @Route("/newreclamation", name="newreclamation")
     */

    public function newreseclamation(Request $request, \Swift_Mailer $mailer)
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        /*$form -> add ('Add.a.new.Reclamation', SubmitType::Class);*/
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            $message = (new \Swift_Message('Nouvelle Reclamation'))
                ->setFrom('taabaniesprit@gmail.com')
                ->setTo('hedi.bentiba@esprit.tn')
                ->setBody( "ID : ".$reclamation->getId().
                    " une nouvelle Reclamation de type: ".$reclamation->getType().
                    "
                    
                    "." Description : " .$reclamation->getDescription()
                )
            ;
            $mailer->send($message);
            $this->addFlash(
                'info',
                'Added Successfully'
            );
            return $this->redirectToRoute('listrec');
        }
        return $this->render('reclamation/newreclamation.html.twig', [
            'form_title' => "Ajouter Une Reclamation",
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/updatereclamation/{id}", name="updatereclamation")
     */
    public function updatereclamation(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->add('Update/Modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash(
                'info',
                'Updated Successfully'
            );
            return $this->redirectToRoute('listrec');
        }
        return $this->render('reclamation/updatereclamation.html.twig', [
            'form_title' => "Modifier Une Reclamation",
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/get/Reclamation",name="getReclamation")
     */
    public function getlistReclamation(ReclamationRepository $repo, NormalizerInterface $Normalizer)
    {
        $reclamation = $repo->findAll();
        //dump($user);
        $json = $Normalizer->normalize($reclamation, 'json', ['groups' => 'reclamation']);

        return new Response(json_encode($json));


    }

    /**
     * @Route("/activedesactive/{id}", name="activedesactive", methods={"GET", "POST"})
     */
    public function activedesactive(Request $request, EntityManagerInterface $entityManager,$id): Response
    {
        $reclamation = new Reclamation();
        $reclamation=$this->getDoctrine()->getRepository(Reclamation::class)->find($id);

        if($reclamation->getEtat()==0) {
            $reclamation->setEtat(1);
        }else {
            $reclamation->setEtat(0);
        }

        $entityManager->persist($reclamation);
        $entityManager->flush();

        return $this->redirectToRoute('listrec', [], Response::HTTP_SEE_OTHER);

    }






}
