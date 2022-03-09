<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Form\DestinationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DestinationController extends AbstractController
{
    /**
     * @Route("/index", name="destination")
     */
    public function index(): Response
    {
        return $this->render('destination/index.html.twig', [
            'controller_name' => 'DestinationController',
        ]);
    }

    /**
     * @Route("/Destination/ajouter", name="create_delegation")
     */
    public function create(Request $request): Response
    {

        $destination = new Destination();
        $form = $this->createForm(DestinationType::class, $destination);
        $form->add('save', SubmitType::class, ['label' => 'Enregistrer']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $destination->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('img_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $em = $this->getDoctrine()->getManager();
            $destination->setImage($fileName);
            $em->persist($destination);
            $em->flush();


            return $this->redirectToRoute('create_delegation');
        } else {
            return $this->render('destination/adddestination.html.twig', [
                'controller_name' => 'DestinationController',
                'form' => $form->createView()
            ]);
        }
    }


    /**
     * @Route("/Destinations", name="read_destination")
     */
    public function Read(): Response
    {
        $liste_destination = $this->getDoctrine()->getRepository(Destination::class)
            ->findAll();
        return $this->render('destination/index.html.twig', [
            'controller_name' => 'CategorieController',
            'liste_destination' => $liste_destination

        ]);
    }


    /**
     * @Route("/Destination/supp/{id}", name="delete_destination")
     */
    public function delete($id)
    {

        $obj = $this->getDoctrine()->getRepository(Destination::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('read_destination');
    }


    /**
     * @Route("/Destination/modif/{id}", name="update_destination")
     */
    public function Update(Request $request, $id)
    { //chercher object a modifier

        $obj = $this->getDoctrine()->getRepository(Destination::class)->find($id);
        $form = $this->createForm(DestinationType::class, $obj);
        $form->add(
            'update',
            SubmitType::class,
            ['label' => 'Modifier']
        );
        $form->handleRequest($request);
        if (($form->isSubmitted()) && ($form->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('read_destination');
        } else {
            return $this->render(
                'destination/editdestination.html.twig',
                ['form' => $form->createView()]
            );
        }
    }
}
