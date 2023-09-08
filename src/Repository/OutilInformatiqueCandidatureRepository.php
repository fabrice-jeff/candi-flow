<?php

namespace App\Repository;

use App\Entity\OutilInformatiqueCandidature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OutilInformatiqueCandidature>
 *
 * @method OutilInformatiqueCandidature|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutilInformatiqueCandidature|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutilInformatiqueCandidature[]    findAll()
 * @method OutilInformatiqueCandidature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutilInformatiqueCandidatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OutilInformatiqueCandidature::class);
    }

//    /**
//     * @return OutilInformatiqueCandidature[] Returns an array of OutilInformatiqueCandidature objects
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

//    public function findOneBySomeField($value): ?OutilInformatiqueCandidature
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
