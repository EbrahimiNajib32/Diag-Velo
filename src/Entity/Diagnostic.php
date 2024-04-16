<?php

namespace App\Entity;

use App\Repository\DiagnosticRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiagnosticRepository::class)]
class Diagnostic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_diagnostic = null;

    #[ORM\Column]
    private ?int $id_velo = null;

    #[ORM\Column]
    private ?int $id_user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_diagnostic = null;

    #[ORM\Column(nullable: true)]
    private ?int $coup_reparation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conclusion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdDiagnostic(): ?int
    {
        return $this->id_diagnostic;
    }

    public function setIdDiagnostic(int $id_diagnostic): static
    {
        $this->id_diagnostic = $id_diagnostic;

        return $this;
    }

    public function getIdVelo(): ?int
    {
        return $this->id_velo;
    }

    public function setIdVelo(int $id_velo): static
    {
        $this->id_velo = $id_velo;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getDateDiagnostic(): ?\DateTimeInterface
    {
        return $this->date_diagnostic;
    }

    public function setDateDiagnostic(\DateTimeInterface $date_diagnostic): static
    {
        $this->date_diagnostic = $date_diagnostic;

        return $this;
    }

    public function getCoupReparation(): ?int
    {
        return $this->coup_reparation;
    }

    public function setCoupReparation(?int $coup_reparation): static
    {
        $this->coup_reparation = $coup_reparation;

        return $this;
    }

    public function getConclusion(): ?string
    {
        return $this->conclusion;
    }

    public function setConclusion(?string $conclusion): static
    {
        $this->conclusion = $conclusion;

        return $this;
    }
}
