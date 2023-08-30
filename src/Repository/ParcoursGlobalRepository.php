<?php

namespace App\Repository;

use App\Entity\ParcoursGlobal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParcoursGlobal>
 *
 * @method ParcoursGlobal|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParcoursGlobal|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParcoursGlobal[]    findAll()
 * @method ParcoursGlobal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParcoursGlobalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParcoursGlobal::class);
    }

//    /**
//     * @return ParcoursGlobal[] Returns an array of ParcoursGlobal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ParcoursGlobal
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
