<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\DestinationRepository;
use App\Entity\Cout;
use App\Entity\Destination;
use App\Entity\destinationSearch;
use App\Entity\Gouvernorat;
use App\Entity\SousCategorie;
use App\Form\DestinationSearchType;
use App\Form\DestinationType;
use Doctrine\DBAL\Types\ArrayType;
use Knp\Component\Pager\PaginatorInterface;
use PhpParser\Node\Stmt\Catch_;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\Length;

class DestinationController extends Controller
{
    /**
     * @Route("/des", name="destination")
     */
    public function index(Request $request, DestinationRepository $repo, PaginatorInterface $paginator): Response
    {

        $search = new destinationSearch();
        $form = $this->createForm(DestinationSearchType::class, $search);
        $form->handleRequest($request);

        $liste_destination = $paginator->paginate($repo->findAllVisible($search), $request->query->getInt('page', 1), 4);

        $souscategories = $this->getDoctrine()->getRepository(SousCategorie::class)->findAll();
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('destination/destination_fornt.html.twig', [
            "souscat" => $categorie,
            "souscategories" => $souscategories,
            'liste_destination' => $liste_destination,
            'form' => $form->createView()


        ]);
    }
    /**
     * @Route("/dest/{id}", name="showcout")
     */
    public function couts($id)
    {
        $destination = $this->getDoctrine()->getRepository(Destination::class)->find($id);
        $cout = $this->getDoctrine()->getRepository(Cout::class)->findBy(array('destination' => $destination->getId()));

        return $this->render('destination/showcout.html.twig', [
            "destination" => $destination,
            "cout" => $cout,
        ]);
    }


    /**
     * @Route("/Destination/ajouter", name="create_destination")
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


            return $this->redirectToRoute('read_destination');
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

    /**
     * @Route("/destinationbycategorie/{id}", name="destination_essai")
     */
    public function destByCategorie(Request $request, DestinationRepository $repo, $id): Response
    {
        $search = new destinationSearch();
        $form = $this->createForm(DestinationSearchType::class, $search);
        $form->handleRequest($request);

        $liste_destination = $repo->findDestinationByString($id);
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->findAll();





        return $this->render('destination/destination.html.twig', [
            'controller_name' => 'DestinationController',
            "souscat" => $categorie,

            'liste_destination' => $liste_destination,
            'form' => $form->createView()

        ]);
    }

    /**
     * @Route("/destinationbycouts", name="prix")
     */
    public function destinationbycouts(): Response
    {
        return $this->render('destination/essai.html.twig', []);
    }

    /**
     * @Route("/destination/statistiques", name="statistiques")
     */
    public function statistiques(DestinationRepository $repo): Response
    {
        $Gouvernorats = $this->getDoctrine()->getRepository(Gouvernorat::class)->findAll();

        $datagouv = array();
        $labelgouv = array();
        foreach ($Gouvernorats as $cat) {
            array_push($datagouv, $repo->DestinationByGouvernoratstat($cat->getId()));
            array_push($labelgouv, $cat->getNom());
        }
        $souscategories = $this->getDoctrine()->getRepository(SousCategorie::class)->findAll();


        $data = array();
        $label = array();
        foreach ($souscategories as $cat) {
            array_push($data, $repo->destinationStat($cat->getId()));
            array_push($label, $cat->getLibelle());
        }
        return $this->render('destination/statistiques.html.twig', [
            'data' => json_encode($data),
            'label' => json_encode($label),
            'datagouv' => json_encode($datagouv),
            'labelgouv' => json_encode($labelgouv),


        ]);
    }
}