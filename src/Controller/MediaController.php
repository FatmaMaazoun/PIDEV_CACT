<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Media;
use App\Entity\Produit;
use App\Form\AvisType;
use App\Form\MediaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController
{
    /**
     * @Route("/media", name="media")
     */
    public function index(): Response
    {
        return $this->render('media/index.html.twig', [
            'controller_name' => 'MediaController',
        ]);
    }
    /**
     * @Route("/mediaftest", name="media_affiche")
     */
    public function Affiche()
    {
        $media = $this->getDoctrine()->getRepository(Media::class)->findAll();
        return $this->render('media/listemedia.html.twig', ['media' => $media]);
    }
    /**
     * @Route("/deletmed", name="avis_delete", methods={"POST"})
     */
    public function delete(Request $request, $id, Media $media): Response
    {
        $media = $this->getDoctrine()->getRepository(Media::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($media);
        $em->flush();
        return $this->redirectToRoute('media_listemedia');
    }
    /**
     * @Route("/addmed", name="media_add", methods={"GET", "POST"})
     */
    public function Add(Request $request): Response
    {
        $med = new Media();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(MediaType::class, $med);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($med);
            $em->flush();
            return $this->redirectToRoute('media_affiche');
        }
        return $this->render('media/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/updatmed", name="media_update", methods={"GET", "POST"})
     */
    public function update(Request $request, Media $media): Response
    {
        $form = $this->createForm(AvisType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('avis_listemedia');
        }

        return $this->render('media/update.html.twig', [
            'media' => $media,
            'form' => $form->createView(),
        ]);

    }
}
