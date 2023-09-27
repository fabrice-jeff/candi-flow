<?php

namespace App\Repository;

use App\Entity\AutreExigence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AutreExigence>
 *
 * @method AutreExigence|null find($id, $lockMode = null, $lockVersion = null)
 * @method AutreExigence|null findOneBy(array $criteria, array $orderBy = null)
 * @method AutreExigence[]    findAll()
 * @method AutreExigence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutreExigenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AutreExigence::class);
    }

//    /**
//     * @return AutreExigence[] Returns an array of AutreExigence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AutreExigence
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
