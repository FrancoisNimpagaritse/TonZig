<?php

namespace App\Repository;

use App\Entity\MeetingAppliedSanction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MeetingAppliedSanction|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeetingAppliedSanction|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeetingAppliedSanction[]    findAll()
 * @method MeetingAppliedSanction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingAppliedSanctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeetingAppliedSanction::class);
    }

    // /**
    //  * @return MeetingAppliedSanction[] Returns an array of MeetingAppliedSanction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MeetingAppliedSanction
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
