<?php

namespace App\Entity;

use App\Repository\DiagnosticTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiagnosticTypeRepository::class)]
class DiagnosticType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomType = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCreationType = null;

    #[ORM\Column]
    private ?bool $actif = null;

    public function __construct()
    {
        $this->id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function addId(ElementControl $id): static
    {
        if (!$this->id->contains($id)) {
            $this->id->add($id);
        }

        return $this;
    }

    public function removeId(ElementControl $id): static
    {
        $this->id->removeElement($id);

        return $this;
    }

    public function getNomType(): ?string
    {
        return $this->nomType;
    }

    public function setNomType(string $nomType): static
    {
        $this->nomType = $nomType;

        return $this;
    }

    public function getDateCreationType(): ?\DateTimeInterface
    {
        return $this->dateCreationType;
    }

    public function setDateCreationType(\DateTimeInterface $dateCreationType): static
    {
        $this->dateCreationType = $dateCreationType;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;

        return $this;
    }
}
