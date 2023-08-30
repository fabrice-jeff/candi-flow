<?php

namespace App\Repository;

use App\Entity\ParcoursSpecifique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParcoursSpecifique>
 *
 * @method ParcoursSpecifique|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParcoursSpecifique|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParcoursSpecifique[]    findAll()
 * @method ParcoursSpecifique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParcoursSpecifiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParcoursSpecifique::class);
    }

//    /**
//     * @return ParcoursSpecifique[] Returns an array of ParcoursSpecifique objects
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

//    public function findOneBySomeField($value): ?ParcoursSpecifique
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
