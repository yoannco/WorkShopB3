<?php

namespace App\Repository;

use App\Entity\UserAssociation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserAssociation|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAssociation|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAssociation[]    findAll()
 * @method UserAssociation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PairRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAssociation::class);
    }

    // /**
    //  * @return Pair[] Returns an array of Pair objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pair
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
