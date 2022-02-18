<?php

namespace App\Repository;

use App\Entity\DemandeEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DemandeEvenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeEvenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeEvenement[]    findAll()
 * @method DemandeEvenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeEvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeEvenement::class);
    }

    // /**
    //  * @return DemandeEvenement[] Returns an array of DemandeEvenement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DemandeEvenement
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
