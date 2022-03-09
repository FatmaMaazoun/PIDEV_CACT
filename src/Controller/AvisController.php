<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\EntityManagerInterface;
use Snipe\BanBuilder\CensorWords;

class AvisController extends AbstractController
{
    /**
     * @Route("/avis", name="avis")
     */
    public function index(): Response
    {
        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
        ]);
    }

    /**
     * @Route("/avi/Affiche", name="avis_affiche")
     */
    public function Affiche()
    {
        $avis = $this->getDoctrine()->getRepository(Avis::class)->findAll();
        return $this->render('avis/listeavis.html.twig', [
            'avis' => $avis
        ]);
    }


    /**
     * @Route("/deleteavis/{id}", name="avis_delete")
     */
    public function delete($id, Avis $avis): Response
    {
        $avis = $this->getDoctrine()->getRepository(Avis::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($avis);
        $em->flush();
        return $this->redirectToRoute('avis_affiche');
    }

    /**
     * @Route("/ajouteavis", name="avis_add")
     */
    public function Add(Request $request): Response
    {
        $avi = new Avis();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $censor = new CensorWords;
            $langs = array('fr','it','en-us','en-uk','de','es');
            $badwords = $censor->setDictionary($langs);
            $censor->setReplaceChar("*");
            $string = $censor->censorString($avi->getCommentaire());
            $avi->setCommentaire($string['clean']);
            $em->persist($avi);
            $em->flush();
            return $this->redirectToRoute('avis_affiche');
        }
        return $this->render('avis/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/avis/update/{id}", name="avis_update")
     */
    public function update(Request $request, $id)
    {
        $avi = new Avis();
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('avis_affiche');
        }

        return $this->render('avis/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}
