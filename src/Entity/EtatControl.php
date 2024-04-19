<?php

namespace App\Entity;

use App\Repository\EtatControlRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatControlRepository::class)]
class EtatControl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $nom_etat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEtat(): ?string
    {
        return $this->nom_etat;
    }

    public function setNomEtat(string $nom_etat): static
    {
        $this->nom_etat = $nom_etat;

        return $this;
    }
}
