<?php

namespace App\Repository;

use App\Entity\ElementControl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ElementControl>
 *
 * @method ElementControl|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElementControl|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElementControl[]    findAll()
 * @method ElementControl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElementControlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElementControl::class);
    }

//    /**
//     * @return ElementControl[] Returns an array of ElementControl objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ElementControl
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
