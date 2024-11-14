<?php

namespace App\Repository;

use App\Entity\TypeLieu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeLieu>
 *
 * @method TypeLieu|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeLieu|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeLieu[]    findAll()
 * @method TypeLieu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeLieuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeLieu::class);
    }

    //    /**
    //     * @return TypeLieu[] Returns an array of TypeLieu objects
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

    //    public function findOneBySomeField($value): ?TypeLieu
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
