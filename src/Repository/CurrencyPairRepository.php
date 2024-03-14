<?php

namespace App\Repository;

use App\Entity\CurrencyPair;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CurrencyPair>
 *
 * @method CurrencyPair|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrencyPair|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrencyPair[]    findAll()
 * @method CurrencyPair[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyPairRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurrencyPair::class);
    }

//    /**
//     * @return CurrencyPair[] Returns an array of CurrencyPair objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CurrencyPair
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
