<?php

namespace App\Repository;

use App\Entity\MeetingLotDistribution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MeetingLotDistribution|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeetingLotDistribution|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeetingLotDistribution[]    findAll()
 * @method MeetingLotDistribution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingLotDistributionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeetingLotDistribution::class);
    }

    // /**
    //  * @return MeetingLotDistribution[] Returns an array of MeetingLotDistribution objects
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
    public function findOneBySomeField($value): ?MeetingLotDistribution
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
