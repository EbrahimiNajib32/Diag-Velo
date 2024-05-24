<?php

namespace App\Entity;

use App\Repository\DiagnosticTypeElementcontrolRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiagnosticTypeElementcontrolRepository::class)]
class DiagnosticTypeElementcontrol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'diagnosticTypeElementcontrols')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DiagnosticType $idDianosticType = null;

    #[ORM\ManyToOne(inversedBy: 'diagnosticTypeElementcontrols')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ElementControl $idElementcontrol = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getIdDianosticType(): ?DiagnosticType
    {
        return $this->idDianosticType;
    }

    public function setIdDianosticType(?DiagnosticType $idDianosticType): static
    {
        $this->idDianosticType = $idDianosticType;

        return $this;
    }

    public function getIdElementcontrol(): ?ElementControl
    {
        return $this->idElementcontrol;
    }

    public function setIdElementcontrol(?ElementControl $idElementcontrol): static
    {
        $this->idElementcontrol = $idElementcontrol;

        return $this;
    }
}
