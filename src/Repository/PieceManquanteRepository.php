<?php

namespace App\Repository;

use App\Entity\PieceManquante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PieceManquante>
 *
 * @method PieceManquante|null find($id, $lockMode = null, $lockVersion = null)
 * @method PieceManquante|null findOneBy(array $criteria, array $orderBy = null)
 * @method PieceManquante[]    findAll()
 * @method PieceManquante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PieceManquanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PieceManquante::class);
    }

//    /**
//     * @return PieceManquante[] Returns an array of PieceManquante objects
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

//    public function findOneBySomeField($value): ?PieceManquante
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
