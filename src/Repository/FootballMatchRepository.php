<?php

namespace App\Repository;

use App\Entity\FootballMatch;
use App\Entity\FootballTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FootballMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method FootballMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method FootballMatch[]    findAll()
 * @method FootballMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method FootballMatch[]    findByWeek(int $week)
 */
class FootballMatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FootballMatch::class);
    }

    /**
     * @param FootballTeam[] $teams
     * @param int $week
     *
     * @return bool
     *
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function hasMatches(array $teams, int $week): bool
    {
        return 0 < (int)$this->createQueryBuilder('fm')
                ->select('count(fm.id)')
                ->andWhere('fm.homeTeam IN (:teams) OR fm.guestTeam IN (:teams)')
                ->setParameter('teams', $teams)
                ->andWhere('fm.week=:week')
                ->setParameter('week', $week)
                ->getQuery()
                ->getSingleScalarResult();
    }

    /**
     * @param FootballTeam $team
     * @param int $fromWeek
     * @param null|int $toWeek
     *
     * @return FootballMatch[]
     */
    public function findMatchesByWeekRange(FootballTeam $team, int $fromWeek, int $toWeek = null): array
    {
        $qb = $this->createQueryBuilder('fm')
            ->andWhere('fm.homeTeam=:team OR fm.guestTeam=:team')
            ->setParameter('team', $team)
            ->andWhere('fm.week>=:fromWeek')
            ->setParameter('fromWeek', $fromWeek);

        if (isset($toWeek)) {
            $qb->andWhere('fm.week<:toWeek')
                ->setParameter('toWeek', $toWeek);
        }

        return $qb->getQuery()
            ->getResult();
    }

    // /**
    //  * @return FootballMatch[] Returns an array of FootballMatch objects
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
    public function findOneBySomeField($value): ?FootballMatch
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
