<?php

namespace App\Repository;

use App\Entity\CritereExigence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CritereExigence>
 *
 * @method CritereExigence|null find($id, $lockMode = null, $lockVersion = null)
 * @method CritereExigence|null findOneBy(array $criteria, array $orderBy = null)
 * @method CritereExigence[]    findAll()
 * @method CritereExigence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CritereExigenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CritereExigence::class);
    }

//    /**
//     * @return CritereExigence[] Returns an array of CritereExigence objects
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

//    public function findOneBySomeField($value): ?CritereExigence
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
