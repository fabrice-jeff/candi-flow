<?php

namespace App\Repository;

use App\Entity\AutreInformationCandidature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AutreInformationCandidature>
 *
 * @method AutreInformationCandidature|null find($id, $lockMode = null, $lockVersion = null)
 * @method AutreInformationCandidature|null findOneBy(array $criteria, array $orderBy = null)
 * @method AutreInformationCandidature[]    findAll()
 * @method AutreInformationCandidature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutreInformationCandidatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AutreInformationCandidature::class);
    }

//    /**
//     * @return AutreInformationCandidature[] Returns an array of AutreInformationCandidature objects
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

//    public function findOneBySomeField($value): ?AutreInformationCandidature
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
