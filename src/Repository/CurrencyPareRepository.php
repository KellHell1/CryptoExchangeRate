<?php

namespace App\Repository;

use App\Entity\CurrencyPare;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CurrencyPare>
 *
 * @method CurrencyPare|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrencyPare|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrencyPare[]    findAll()
 * @method CurrencyPare[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyPareRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurrencyPare::class);
    }

//    /**
//     * @return CurrencyPare[] Returns an array of CurrencyPare objects
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

//    public function findOneBySomeField($value): ?CurrencyPare
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
