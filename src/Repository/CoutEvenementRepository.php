<?php

namespace App\Repository;

use App\Entity\CoutEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
}
