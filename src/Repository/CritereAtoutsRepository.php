<?php

namespace App\Repository;

use App\Entity\CritereAtouts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CritereAtouts>
 *
 * @method CritereAtouts|null find($id, $lockMode = null, $lockVersion = null)
 * @method CritereAtouts|null findOneBy(array $criteria, array $orderBy = null)
 * @method CritereAtouts[]    findAll()
 * @method CritereAtouts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CritereAtoutsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CritereAtouts::class);
    }

//    /**
//     * @return CritereAtouts[] Returns an array of CritereAtouts objects
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

//    public function findOneBySomeField($value): ?CritereAtouts
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
