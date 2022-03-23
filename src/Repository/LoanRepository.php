<?php

namespace App\Repository;

use App\Entity\Loan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Loan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Loan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Loan[]    findAll()
 * @method Loan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loan::class);
    }

    public function getMemberLoanDues($member)
    {
        return $this->createQueryBuilder('l')
                    ->select('l.id, l.disbursedAt, l.amount, l.status')
                    ->addSelect('SUM(d.principal) as principal_due, SUM(d.interest) as interets_tot')
                    ->addSelect('u.firstname, u.lastname')
                    ->innerJoin('l.dues', 'd', 'WITH', 'd.loan = l')
                    ->innerJoin('l.member', 'u', 'WITH', 'l.member = u')
                    ->where('l.member = :mbr')
                    ->setParameter('mbr', $member)
                    ->groupBy('l.id, l.disbursedAt, l.amount, l.status')
                    ->getQuery()
                    ->getResult();
    }

    public function getMemberLoanPayments($member)
    {
        return $this->createQueryBuilder('l')
                    ->select('l.id, l.disbursedAt, l.amount, l.status')
                    ->addSelect('SUM(p.principal) as principal_paye, SUM(p.interest) as interets_payes')
                    ->addSelect('u.firstname, u.lastname')
                    ->innerJoin('l.payments', 'p', 'WITH', 'p.loan = l')
                    ->innerJoin('l.member', 'u', 'WITH', 'l.member = u')
                    ->where('l.member = :mbr')
                    ->setParameter('mbr', $member)
                    ->groupBy('l.id, l.disbursedAt, l.amount, l.status')
                    ->getQuery()
                    ->getResult();
    }

    public function getAllLoansBalance()
    {
        return $this->createQueryBuilder('l')
                    ->select('l.id, l.disbursedAt, l.amount, l.status')
                    ->addSelect('u.firstname, u.lastname')
                    ->addSelect('SUM(d.principal) AS totalPrincipalDue, SUM(d.interest) as totalInterestDue')
                    ->addSelect('SUM(p.principal) AS totalPrincipalPaid, SUM(p.interest) as totalInteretPaid')
                    ->addSelect('(l.amount - SUM(p.principal)) AS soldePrincipal1, (SUM(d.principal) - SUM(p.principal)) as soldePrincipal2, (SUM(d.interest) - SUM(p.interest)) as soldeInterest, (SUM(d.penality) - SUM(p.penality)) AS soldePenality')
                    ->addSelect('(l.amount + SUM(d.interest) + SUM(d.penality) - SUM(p.principal)- SUM(p.interest) - SUM(p.penality)) AS soldeTotal')
                    ->leftJoin('l.payments', 'p', 'WITH', 'p.loan = l')
                    ->leftJoin('l.dues', 'd', 'WITH', 'd.loan = l')
                    ->innerJoin('l.member', 'u', 'WITH', 'l.member = u')
                    //->setParameter('status', $status)//to be passed as parameter
                    ->groupBy('l.id, l.disbursedAt, l.amount, u.firstname, u.lastname, l.status')
                    ->orderBy('l.disbursedAt', 'DESC')
                    ->getQuery()
                    ->getResult();
    }

    // /**
    //  * @return Loan[] Returns an array of Loan objects
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
    public function findOneBySomeField($value): ?Loan
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
