<?php

namespace App\Repository;

use App\Entity\CritereExperience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CritereExperience>
 *
 * @method CritereExperience|null find($id, $lockMode = null, $lockVersion = null)
 * @method CritereExperience|null findOneBy(array $criteria, array $orderBy = null)
 * @method CritereExperience[]    findAll()
 * @method CritereExperience[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CritereExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CritereExperience::class);
    }

//    /**
//     * @return CritereExperience[] Returns an array of CritereExperience objects
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

//    public function findOneBySomeField($value): ?CritereExperience
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
