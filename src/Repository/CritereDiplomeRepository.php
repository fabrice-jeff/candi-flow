<?php

namespace App\Repository;

use App\Entity\CritereDiplome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CritereDiplome>
 *
 * @method CritereDiplome|null find($id, $lockMode = null, $lockVersion = null)
 * @method CritereDiplome|null findOneBy(array $criteria, array $orderBy = null)
 * @method CritereDiplome[]    findAll()
 * @method CritereDiplome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CritereDiplomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CritereDiplome::class);
    }

//    /**
//     * @return CritereDiplome[] Returns an array of CritereDiplome objects
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

//    public function findOneBySomeField($value): ?CritereDiplome
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
