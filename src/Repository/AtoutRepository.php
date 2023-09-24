<?php

namespace App\Repository;

use App\Entity\Atout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Atout>
 *
 * @method Atout|null find($id, $lockMode = null, $lockVersion = null)
 * @method Atout|null findOneBy(array $criteria, array $orderBy = null)
 * @method Atout[]    findAll()
 * @method Atout[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtoutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Atout::class);
    }

//    /**
//     * @return Atout[] Returns an array of Atout objects
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

//    public function findOneBySomeField($value): ?Atout
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
