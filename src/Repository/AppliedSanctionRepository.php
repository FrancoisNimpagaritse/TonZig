<?php

namespace App\Repository;

use App\Entity\AppliedSanction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AppliedSanction|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppliedSanction|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppliedSanction[]    findAll()
 * @method AppliedSanction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppliedSanctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppliedSanction::class);
    }

    // /**
    //  * @return AppliedSanction[] Returns an array of AppliedSanction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AppliedSanction
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
