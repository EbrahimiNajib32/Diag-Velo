<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Velo;
use App\Entity\Diagnostic;
use App\Entity\Proprietaire;
use App\Entity\Lieu;
use App\Entity\TypeLieu;


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

   public function getDatesDiagnostic(): array
    {
        $query = $this->entityManager->getRepository(Diagnostic::class)->createQueryBuilder('d')
            ->select('DISTINCT d.date_diagnostic')
            ->getQuery();

        $result = $query->getResult();

        return array_column($result, 'date_diagnostic');
    }

    public function getConclusionsDiagnostic(): array
    {
        $query = $this->entityManager->getRepository(Diagnostic::class)->createQueryBuilder('d')
            ->select('DISTINCT d.conclusion')
            ->getQuery();

        $result = $query->getResult();

        return array_column($result, 'conclusion');
    }

    public function getStatusDiagnostic(): array
    {
        $query = $this->entityManager->getRepository(Diagnostic::class)->createQueryBuilder('d')
            ->select('DISTINCT d.status')
            ->getQuery();

        $result = $query->getResult();

        return array_column($result, 'status');
    }

    public function getNomsProprio(): array
    {
        $query = $this->entityManager->getRepository(Proprietaire::class)->createQueryBuilder('p')
            ->select('DISTINCT p.nom_proprio')
            ->getQuery();

        $result = $query->getResult();

        return array_column($result, 'nom_proprio');
    }

    public function getStatutsProprio(): array
    {
        $query = $this->entityManager->getRepository(Proprietaire::class)->createQueryBuilder('p')
            ->select('DISTINCT p.statut')
            ->getQuery();

        $result = $query->getResult();

        return array_column($result, 'statut');
    }

    public function getPrenomProprio(): array
    {
        $query = $this->entityManager->getRepository(Proprietaire::class)->createQueryBuilder('p')
            ->select('DISTINCT p.prenom')
            ->getQuery();

        $result = $query->getResult();

        return array_column($result, 'prenom');
    }

    public function getDateDeNaissanceProprio(): array
    {
        $query = $this->entityManager->getRepository(Proprietaire::class)->createQueryBuilder('p')
            ->select('DISTINCT p.date_de_naissance')
            ->getQuery();

        $result = $query->getResult();

        return array_column($result, 'date_de_naissance');
    }

    public function getLieuxDetails(): array
    {
        $query = $this->entityManager->getRepository(Lieu::class)->createQueryBuilder('l')
            ->select('l.nom_lieu, l.ville, l.code_postal')
            ->getQuery();

        $result = $query->getResult();

        return $result; // Retourne un tableau avec les détails
    }

    public function getNomsTypesLieu(): array
    {
        $query = $this->entityManager->getRepository(TypeLieu::class)->createQueryBuilder('t')
            ->select('DISTINCT t.nom_type_lieu')
            ->getQuery();

        $result = $query->getResult();

        return array_column($result, 'nom_type_lieu'); // Retourne uniquement les noms
    }

}
