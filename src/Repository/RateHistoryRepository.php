<?php

namespace App\Repository;

use App\Entity\CurrencyPair;
use App\Entity\RateHistory;
use DateTime;
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

    /**
     * @param CurrencyPair $currencyPair
     * @param DateTime $dateFrom
     * @param DateTime $dateTo
     * @return RateHistory[] Returns an array of RateHistory objects
     */
    public function findByDateTimeRangeAndPair(CurrencyPair $currencyPair, DateTime $dateFrom, DateTime $dateTo): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.currencyPair = :currencyPair')
            ->setParameter('currencyPair', $currencyPair)
            ->andWhere('r.datetime BETWEEN :dateFrom AND :dateTo')
            ->setParameter('dateFrom', $dateFrom->format('Y-m-d H:i:s'))
            ->setParameter('dateTo', $dateTo->format('Y-m-d H:i:s'))
            ->orderBy('r.datetime', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
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
