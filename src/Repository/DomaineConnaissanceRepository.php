<?php

namespace App\Repository;

use App\Entity\DomaineConnaissance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DomaineConnaissance>
 *
 * @method DomaineConnaissance|null find($id, $lockMode = null, $lockVersion = null)
 * @method DomaineConnaissance|null findOneBy(array $criteria, array $orderBy = null)
 * @method DomaineConnaissance[]    findAll()
 * @method DomaineConnaissance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DomaineConnaissanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DomaineConnaissance::class);
    }

//    /**
//     * @return DomaineConnaissance[] Returns an array of DomaineConnaissance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DomaineConnaissance
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
