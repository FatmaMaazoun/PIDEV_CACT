<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

    
    /**
     * @param ReservationRepository $Repository
     * @return \symfony\Component\HttpFoundation\Response
     * @Route ("/listres", name="listres")
     */
    public function afficheres(ReservationRepository $Repository)
    {
        $resevent = $Repository->findAll();
        return $this->render('reservation/listeres.html.twig', [
            'reservation' => $resevent,
        ]);
    }
    /**
     * @param ReservationRepository $Repository
     * @return \symfony\Component\HttpFoundation\Response
     * @return \symfony\Component\HttpFoundation\Request

     * @Route ("/deletereservation/{id}",name="deletereservation")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository(Reservation::class)->find($id);
        $em->remove($reservation);
        $em->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('listres');
    }
    /**
     * @Route("/newreservation", name="newreservation")
     */

    public function newreservation(Request $request)
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->add('Add.a.new.Reservation', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('listres');
        }
        return $this->render('reservation/newreservation.html.twig', [
            'form_title' => "Ajouter Une Reservation",
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/updatereservation/{id}", name="updatereservation")
     */
    public function updatereservation(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository(Reservation::class)->find($id);
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->add('Update/Modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('listres');
        }
        return $this->render('reservation/updatereservation.html.twig', [
            'form_title' => "Modifier Une Reservation",
            'form' => $form->createView(),
        ]);
    }
}
