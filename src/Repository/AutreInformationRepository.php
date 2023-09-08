<?php

namespace App\Repository;

use App\Entity\AutreInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AutreInformation>
 *
 * @method AutreInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AutreInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method AutreInformation[]    findAll()
 * @method AutreInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutreInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AutreInformation::class);
    }

//    /**
//     * @return AutreInformation[] Returns an array of AutreInformation objects
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

//    public function findOneBySomeField($value): ?AutreInformation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
