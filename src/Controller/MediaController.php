<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Media;
use App\Entity\Produit;
use App\Form\AvisType;
use App\Form\MediaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
     * @Route("/media/afficher", name="media_affiche")
     */
    public function Affiche()
    {
        $media = $this->getDoctrine()->getRepository(Media::class)->findAll();
        return $this->render('media/listemedia.html.twig', ['media' => $media]);
    }
    /**
     * @Route("/deletmed/{id}", name="media_delete")
     */
    public function delete(Request $request, $id, Media $media)

    {   $media=new Media();
        $media = $this->getDoctrine()->getRepository(Media::class)->find($id);
        $form=$this->createForm(MediaType::class,$media);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $em->remove($media);
        $em->flush();
        return $this->redirectToRoute('media_affiche');
    }
    /**
     * @Route("/addmed", name="media_add")
     */
    public function Add(Request $request): Response
    {
        $med = new Media();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(MediaType::class, $med);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('img_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $em->persist($med);
            $em->flush();
            return $this->redirectToRoute('media_affiche');
        }
        return $this->render('media/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/updatmed/{id}", name="media_update")
     */
    public function update(Request $request, $id)
    {
        $media = new Media();
        $media = $this->getDoctrine()->getRepository(Media::class)->find($id);

        $form = $this->createForm(MediaType::class, $media);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('media_affiche');
        }

        return $this->render('media/update.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
