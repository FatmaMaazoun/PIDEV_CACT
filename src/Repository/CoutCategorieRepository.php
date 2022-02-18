<?php

namespace App\Repository;

use App\Entity\CoutCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CoutCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoutCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoutCategorie[]    findAll()
 * @method CoutCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoutCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoutCategorie::class);
    }

    // /**
    //  * @return CoutCategorie[] Returns an array of CoutCategorie objects
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
    public function findOneBySomeField($value): ?CoutCategorie
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
