<?php

namespace App\Repository;

use App\Entity\RegleProcedure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RegleProcedure>
 *
 * @method RegleProcedure|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegleProcedure|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegleProcedure[]    findAll()
 * @method RegleProcedure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegleProcedureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegleProcedure::class);
    }

//    /**
//     * @return RegleProcedure[] Returns an array of RegleProcedure objects
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

//    public function findOneBySomeField($value): ?RegleProcedure
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
