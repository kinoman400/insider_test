<?php

namespace App\Repository;

use App\Entity\FootballGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FootballGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method FootballGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method FootballGroup[]    findAll()
 * @method FootballGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FootballGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FootballGroup::class);
    }

    // /**
    //  * @return FootballGroup[] Returns an array of FootballGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FootballGroup
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
