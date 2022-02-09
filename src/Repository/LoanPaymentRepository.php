<?php

namespace App\Repository;

use App\Entity\LoanPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LoanPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoanPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoanPayment[]    findAll()
 * @method LoanPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoanPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoanPayment::class);
    }

    // /**
    //  * @return LoanPayment[] Returns an array of LoanPayment objects
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
    public function findOneBySomeField($value): ?LoanPayment
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
