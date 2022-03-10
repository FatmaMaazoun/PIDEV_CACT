<?php

namespace App\Controller;

use App\Entity\DemandeEvenement;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\DemandeEvenementRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\BarChart;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation",methods={"GET"})
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
     * @Route ("/listres", name="listres",methods={"GET"})
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
        $this->addFlash(
            'info',
            'Deleted Successfully'
        );
        $response=new Response();
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
            $this->addFlash(
                'info',
                'Added Successfully'
            );
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
            $this->addFlash(
                'info',
                'Updated Successfully'
            );
            return $this->redirectToRoute('listres');
        }
        return $this->render('reservation/updatereservation.html.twig', [
            'form_title' => "Modifier Une Reservation",
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/stat/reservation",name="statistiquesss")
     */

    public function statistiques(DemandeEvenementRepository $demandeEvenementRepository,ReservationRepository  $reservationRepository): Response
    {
        $p=$this->getDoctrine()->getRepository(Reservation::class);
        $nbs = $p->getNb();


        $data = [['Evenement', 'Nombre de Reservation']];

        foreach($nbs as $nb)
        {
            $data[] = array(
                $nb['event'], $nb['res'])
            ;
        }
        $bar = new BarChart();
        $bar->getData()->setArrayToDataTable(
            $data
        );
        $bar->getOptions()->setTitle('Nombre de reservation par evenement');
        $bar->getOptions()->getTitleTextStyle()->setColor('#07600');
        $bar->getOptions()->getTitleTextStyle()->setFontSize(25);
        return $this->render('reservation/Stat.html.twig',
            array('piechart' => $bar,'nbs' => $nbs));

    }



    /**
     * @param Request $request
     * @return Response
     * @Route ("/reservationajax",name="searchres")
     */
    public function searchrdv(Request $requestn)
    {
        $repository = $this->getDoctrine()->getRepository(Reservation::class);
        $requestString=$requestn->get('searchValue');
        $rdv = $repository->findrdvBydate($requestString);
        return $this->render('reservation/ResAjax.html.twig' ,[
            "reservation"=>$rdv,
        ]);
    }
    /**
     * @Route("/pdf", name="pdf", methods={"GET"})
     * @param ReservationRepository $reservationRepository
     * @return Response
     */
    public function pdf(ReservationRepository $reservationRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reservation/pdf.html.twig', [
            'reservation' => $reservationRepository->findAll(),

        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }





}
