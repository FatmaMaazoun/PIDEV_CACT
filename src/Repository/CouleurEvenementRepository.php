<?php

namespace App\Repository;

use App\Entity\CouleurEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CouleurEvenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method CouleurEvenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method CouleurEvenement[]    findAll()
 * @method CouleurEvenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouleurEvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CouleurEvenement::class);
    }

    // /**
    //  * @return CouleurEvenement[] Returns an array of CouleurEvenement objects
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
    public function findOneBySomeField($value): ?CouleurEvenement
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    public function addCouleurEvenement($categorie): ?CouleurEvenement
    {

    $couleurEvenement = new CouleurEvenement();
    if($categorie==culture){
        $couleurEvenement->setBackgrondColor();
        $couleurEvenement->setBorderColor();
        $couleurEvenement->setTextColor();

    }
    else if($categorie==test){
        $couleurEvenement->setBackgrondColor("#ff0000");
        $couleurEvenement->setBorderColor("#0000ff");
        $couleurEvenement->setTextColor("#ffffff");

    }
   
        $em = $this->getDoctrine()->getManager();

        $em->persist($couleurEvenement);
        $em->flush();
}



}
