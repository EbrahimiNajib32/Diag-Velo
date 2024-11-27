<?php

namespace App\Repository;

use App\Entity\DiagnostictypeLieutype;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DiagnostictypeLieutype>
 *
 * @method DiagnostictypeLieutype|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiagnostictypeLieutype|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiagnostictypeLieutype[]    findAll()
 * @method DiagnostictypeLieutype[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiagnostictypeLieutypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiagnostictypeLieutype::class);
    }

    //    /**
    //     * @return DiagnostictypeLieutype[] Returns an array of DiagnostictypeLieutype objects
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

    //    public function findOneBySomeField($value): ?DiagnostictypeLieutype
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
