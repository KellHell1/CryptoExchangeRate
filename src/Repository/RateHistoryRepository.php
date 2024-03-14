<?php

namespace App\Repository;

use App\Entity\RateHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RateHistory>
 *
 * @method RateHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method RateHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method RateHistory[]    findAll()
 * @method RateHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RateHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RateHistory::class);
    }

//    /**
//     * @return RateHistory[] Returns an array of RateHistory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RateHistory
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
