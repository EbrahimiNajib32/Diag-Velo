<?php

namespace App\Entity;

use App\Repository\DiagnostictypeLieutypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiagnostictypeLieutypeRepository::class)]
class DiagnostictypeLieutype
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'diagnostictypeLieutypes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DiagnosticType $diagnostic_type_id = null;

    #[ORM\ManyToOne(inversedBy: 'diagnostictypeLieutypes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeLieu $Lieu_type_id = null;

    #[ORM\Column]
    private ?bool $actif = null;

    /**
     * @var Collection<int, Diagnostic>
     */
    #[ORM\OneToMany(targetEntity: Diagnostic::class, mappedBy: 'Diagnostictype_LieuType_id')]
    private Collection $diagnostics;

    public function __construct()
    {
        $this->diagnostics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiagnosticTypeId(): ?DiagnosticType
    {
        return $this->diagnostic_type_id;
    }

    public function setDiagnosticTypeId(?DiagnosticType $diagnostic_type_id): static
    {
        $this->diagnostic_type_id = $diagnostic_type_id;

        return $this;
    }

    public function getLieuTypeId(): ?TypeLieu
    {
        return $this->Lieu_type_id;
    }

    public function setLieuTypeId(?TypeLieu $Lieu_type_id): static
    {
        $this->Lieu_type_id = $Lieu_type_id;

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

    /**
     * @return Collection<int, Diagnostic>
     */
    public function getDiagnostics(): Collection
    {
        return $this->diagnostics;
    }

    public function addDiagnostic(Diagnostic $diagnostic): static
    {
        if (!$this->diagnostics->contains($diagnostic)) {
            $this->diagnostics->add($diagnostic);
            $diagnostic->setDiagnostictypeLieuTypeId($this);
        }

        return $this;
    }

    public function removeDiagnostic(Diagnostic $diagnostic): static
    {
        if ($this->diagnostics->removeElement($diagnostic)) {
            // set the owning side to null (unless already changed)
            if ($diagnostic->getDiagnostictypeLieuTypeId() === $this) {
                $diagnostic->setDiagnostictypeLieuTypeId(null);
            }
        }

        return $this;
    }
}
