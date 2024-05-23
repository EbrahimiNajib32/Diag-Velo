<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Velo;


class VeloInfoService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getMarques()
    {
        $query = $this->entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.marque')
            ->getQuery();

        $result = $query->getResult();

        return array_map(function ($marque) {
            return $marque['marque'];
        }, $result);
    }

    public function getCouleurs()
    {
        $query = $this->entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.couleur')
            ->getQuery();

        $result = $query->getResult();

        return array_column($result, 'couleur');
    }

    public function getTypes()
    {
        $query = $this->entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.type')
            ->getQuery();

        $result = $query->getResult();

        return array_map(function ($type) {
            return $type['type'];
        }, $result);
    }

    public function getPublics()
    {
        $query = $this->entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.public')
            ->getQuery();

        $result = $query->getResult();

        return array_map(function ($public) {
            return $public['public'];
        }, $result);
    }
}
