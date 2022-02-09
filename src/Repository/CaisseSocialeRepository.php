<?php

namespace App\Repository;

use App\Entity\CaisseSociale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CaisseSociale|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaisseSociale|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaisseSociale[]    findAll()
 * @method CaisseSociale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaisseSocialeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaisseSociale::class);
    }

    // /**
    //  * @return CaisseSociale[] Returns an array of CaisseSociale objects
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
    public function findOneBySomeField($value): ?CaisseSociale
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
