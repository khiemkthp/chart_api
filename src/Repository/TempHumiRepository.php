<?php

namespace App\Repository;

use App\Entity\TempHumi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TempHumi|null find($id, $lockMode = null, $lockVersion = null)
 * @method TempHumi|null findOneBy(array $criteria, array $orderBy = null)
 * @method TempHumi[]    findAll()
 * @method TempHumi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempHumiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TempHumi::class);
    }

    // /**
    //  * @return TempHumi[] Returns an array of TempHumi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TempHumi
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
