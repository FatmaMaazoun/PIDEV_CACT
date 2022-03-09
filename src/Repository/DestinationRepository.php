<?php

namespace App\Repository;

use App\Entity\Destination;
use App\Entity\destinationSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Migrations\Query\Query as QueryQuery;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Destination|null find($id, $lockMode = null, $lockVersion = null)
 * @method Destination|null findOneBy(array $criteria, array $orderBy = null)
 * @method Destination[]    findAll()
 * @method Destination[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DestinationRepository extends ServiceEntityRepository
{



    public function findDestinationByString($id)
    {
        return $this->getEntityManager()->createQuery(
            ' SELECT e
                FROM App\Entity\Destination e , App\Entity\SousCategorie sc ,  App\Entity\Categorie c
                Where  sc.id = e.souscategorie and sc.categorie= c.id
                and  c.id=:id'
        )
            ->setParameter('id', $id)

            ->getResult();
    }

    public function findDestinationByCouts($prix)
    {
        return $this->createQueryBuilder('des')
            ->Join('des.couts', 's')
            ->andWhere('s.prix = :prix')
            ->setParameter('prix', $prix);
    }

    public function findDestinationByGouvernorat($id)
    {
        return  $this->createQueryBuilder('des')
            ->Join('des.delegation', 'd')
            ->Join('d.gouvernorat', 'g')
            ->andWhere('g.id = :id')
            ->setParameter('id', $id);
    }



    public function findAllVisible(destinationSearch $des)
    {
        $query = $this->findVisibleQuery();
        if ($des->getPrix()) {
            $query = $this->findDestinationByCouts($des->getPrix());
        }
        if ($des->getName()) {
            $query = $query
                ->andWhere('des.nom like :nomdes')
                ->setParameter('nomdes', $des->getName());
        }
        if ($des->gouvernorat) {
            $query = $query->Join('des.delegation', 'd')
                ->Join('d.gouvernorat', 'g')
                ->andWhere('g.id = :id')
                ->setParameter('id', $des->gouvernorat);
        }


        return $query;
    }

    public function findVisibleQuery()
    {
        return $this->createQueryBuilder('des');
    }

    public function destinationStat($id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('select COUNT(C) from App\Entity\Destination C where C.souscategorie = :id');
        $query->setParameter('id', $id);
        return $query->getSingleScalarResult();
    }

    public function DestinationByGouvernoratstat($id)
    {
        return $this->getEntityManager()->createQuery(
            ' select COUNT(e)
        FROM App\Entity\Destination e , App\Entity\Delegation sc ,  App\Entity\Gouvernorat c
        Where  e.id = e.delegation and sc.gouvernorat= c.id
        and  c.id=:id'
        )
            ->setParameter('id', $id)
            ->getSingleScalarResult();
    }










    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Destination::class);
    }

    // /**
    //  * @return Destination[] Returns an array of Destination objects
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
    public function findOneBySomeField($value): ?Destination
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
