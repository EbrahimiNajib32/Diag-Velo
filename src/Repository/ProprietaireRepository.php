<?php

namespace App\Repository;

use App\Entity\Proprietaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @extends ServiceEntityRepository<Proprietaire>
 *
 * @method Proprietaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proprietaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proprietaire[]    findAll()
 * @method Proprietaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProprietaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proprietaire::class);
    }

    public function findMatchingProprietaires(string $term): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.nom_proprio LIKE :term')
            ->setParameter('term', '%'.$term.'%')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Proprietaire[] Returns an array of Proprietaire objects
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

//    public function findOneBySomeField($value): ?Proprietaire
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
