<?php

namespace App\Repository;

use App\Entity\DemandeEvenement;
use App\service\Date;
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



    public function listDemandeEvenementEnAttente(){
        return $this->createQueryBuilder('d')
            ->where('d.statut LIKE ?1')
            ->setParameter('1', '%en attente%')
            ->getQuery()
            ->getResult();
    }
    public function listDemandeEvenementRefuser(){
        return $this->createQueryBuilder('d')
            ->where('d.statut LIKE ?1')
            ->setParameter('1', '%Refuser%')
            ->getQuery()
            ->getResult();
    }

    public function listDemandeEvenementAccepter(){
        return $this->createQueryBuilder('d')
            ->where('d.statut LIKE ?1')
            ->setParameter('1', '%Accepter%')
            ->getQuery()
            ->getResult();
    }

    public function listEvenementAccepterDateDans2Semaine(){
        return $this->createQueryBuilder('d')
            ->where('d.statut LIKE ?1')
            ->andWhere('d.date_debutEvent <= :date_start')
            ->andWhere('d.date_finEvent >= :date_end')
            ->setParameter('1', '%Accepter%')
            ->setParameter('date_start', $date->modify('-15 day')->format('Y-m-d 00:00:00'))
            ->setParameter('date_finEvent', $date->format('Y-m-d 00:00:00'))
            ->getQuery()
            ->getResult();
    }
}
