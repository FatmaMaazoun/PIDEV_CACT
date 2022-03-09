<?php

namespace App\Repository;

use App\Entity\CoutEvenement;
use App\Form\CoutEvenementType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
/**
 * @method CoutEvenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoutEvenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoutEvenement[]    findAll()
 * @method CoutEvenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoutEvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoutEvenement::class);
    }

    // /**
    //  * @return CoutEvenement[] Returns an array of CoutEvenement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CoutEvenement
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


/**
 * Allow to add a new Country.
 *
 * @param Request $request
 *
 * @return \Symfony\Component\Form\FormInterface
 */
public function addCountry(Request $request)
{
    $CoutEvenement=new CoutEvenement();
 
    $form = $this->form->create(CoutEvenementType::class, $CoutEvenement);
    $form->handleRequest($request);
 
    if ($form->isSubmitted() && $form->isValid()) {
        $this->doctrine->persist($CoutEvenement);
        $this->doctrine->flush();
        $this->session->getFlashBag()->add('success', 'Le pays a bien été enregistré.');
    }
 
    return $form;
}
public function ListeCoutEvenementByDemanedeEvenement(Request $request)
{
    $CoutEvenement=new CoutEvenement();
 
    $form = $this->form->create(CoutEvenementType::class, $CoutEvenement);
    $form->handleRequest($request);
 
    if ($form->isSubmitted() && $form->isValid()) {
        $this->doctrine->persist($CoutEvenement);
        $this->doctrine->flush();
        $this->session->getFlashBag()->add('success', 'Le pays a bien été enregistré.');
    }
    return $form;
}
public function listCoutEvenementByIdDemandeEvenement($id)
{
    return $this->createQueryBuilder('d')
        ->join('d.demandeEvent', 'c')
        ->addSelect('c')
        ->where('c.id=:id')
        ->setParameter('id',$id)
        ->getQuery()
        ->getResult();
}


}
