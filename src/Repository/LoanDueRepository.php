<?php

namespace App\Repository;

use App\Entity\LoanDue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LoanDue|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoanDue|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoanDue[]    findAll()
 * @method LoanDue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoanDueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoanDue::class);
    }

    // /**
    //  * @return LoanDue[] Returns an array of LoanDue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LoanDue
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
