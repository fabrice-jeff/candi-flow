<?php

namespace App\Repository;

use App\Entity\TotalExperience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TotalExperience>
 *
 * @method TotalExperience|null find($id, $lockMode = null, $lockVersion = null)
 * @method TotalExperience|null findOneBy(array $criteria, array $orderBy = null)
 * @method TotalExperience[]    findAll()
 * @method TotalExperience[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TotalExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TotalExperience::class);
    }

//    /**
//     * @return TotalExperience[] Returns an array of TotalExperience objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TotalExperience
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
