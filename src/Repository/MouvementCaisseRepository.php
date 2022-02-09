<?php

namespace App\Repository;

use App\Entity\MouvementCaisse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MouvementCaisse|null find($id, $lockMode = null, $lockVersion = null)
 * @method MouvementCaisse|null findOneBy(array $criteria, array $orderBy = null)
 * @method MouvementCaisse[]    findAll()
 * @method MouvementCaisse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MouvementCaisseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MouvementCaisse::class);
    }

    // /**
    //  * @return MouvementCaisse[] Returns an array of MouvementCaisse objects
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
    public function findOneBySomeField($value): ?MouvementCaisse
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
