<?php

namespace App\Repository;

use App\Entity\OutilsInformatique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OutilsInformatique>
 *
 * @method OutilsInformatique|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutilsInformatique|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutilsInformatique[]    findAll()
 * @method OutilsInformatique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutilsInformatiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OutilsInformatique::class);
    }

//    /**
//     * @return OutilsInformatique[] Returns an array of OutilsInformatique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OutilsInformatique
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
