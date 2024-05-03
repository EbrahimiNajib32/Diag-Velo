<?php

namespace App\Repository;

use App\Entity\DiagnosticTypeElementcontrol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DiagnosticTypeElementcontrol>
 *
 * @method DiagnosticTypeElementcontrol|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiagnosticTypeElementcontrol|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiagnosticTypeElementcontrol[]    findAll()
 * @method DiagnosticTypeElementcontrol[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiagnosticTypeElementcontrolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiagnosticTypeElementcontrol::class);
    }

//    /**
//     * @return DiagnosticTypeElementcontrol[] Returns an array of DiagnosticTypeElementcontrol objects
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

//    public function findOneBySomeField($value): ?DiagnosticTypeElementcontrol
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
