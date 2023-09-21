<?php

namespace App\Repository;

use App\Entity\MatriceEvaluation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MatriceEvaluation>
 *
 * @method MatriceEvaluation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatriceEvaluation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatriceEvaluation[]    findAll()
 * @method MatriceEvaluation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatriceEvaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatriceEvaluation::class);
    }

//    /**
//     * @return MatriceEvaluation[] Returns an array of MatriceEvaluation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MatriceEvaluation
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
