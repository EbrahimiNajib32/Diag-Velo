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

    /**
     * @var Collection<int, DiagnosticTypeElementcontrol>
     */
    #[ORM\OneToMany(targetEntity: DiagnosticTypeElementcontrol::class, mappedBy: 'idDianosticType', orphanRemoval: true)]
    private Collection $diagnosticTypeElementcontrols;

    /**
     * @var Collection<int, DiagnostictypeLieutype>
     */
    #[ORM\OneToMany(targetEntity: DiagnostictypeLieutype::class, mappedBy: 'diagnostic_type_id')]
    private Collection $diagnostictypeLieutypes;

    public function __construct()
    {
        $this->diagnosticTypeElementcontrols = new ArrayCollection();
        $this->diagnostictypeLieutypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, DiagnosticTypeElementcontrol>
     */
    public function getDiagnosticTypeElementcontrols(): Collection
    {
        return $this->diagnosticTypeElementcontrols;
    }

    public function addDiagnosticTypeElementcontrol(DiagnosticTypeElementcontrol $diagnosticTypeElementcontrol): static
    {
        if (!$this->diagnosticTypeElementcontrols->contains($diagnosticTypeElementcontrol)) {
            $this->diagnosticTypeElementcontrols->add($diagnosticTypeElementcontrol);
            $diagnosticTypeElementcontrol->setIdDianosticType($this);
        }

        return $this;
    }

    public function removeDiagnosticTypeElementcontrol(DiagnosticTypeElementcontrol $diagnosticTypeElementcontrol): static
    {
        if ($this->diagnosticTypeElementcontrols->removeElement($diagnosticTypeElementcontrol)) {
            // set the owning side to null (unless already changed)
            if ($diagnosticTypeElementcontrol->getIdDianosticType() === $this) {
                $diagnosticTypeElementcontrol->setIdDianosticType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DiagnostictypeLieutype>
     */
    public function getDiagnostictypeLieutypes(): Collection
    {
        return $this->diagnostictypeLieutypes;
    }

    public function addDiagnostictypeLieutype(DiagnostictypeLieutype $diagnostictypeLieutype): static
    {
        if (!$this->diagnostictypeLieutypes->contains($diagnostictypeLieutype)) {
            $this->diagnostictypeLieutypes->add($diagnostictypeLieutype);
            $diagnostictypeLieutype->setDiagnosticTypeId($this);
        }

        return $this;
    }

    public function removeDiagnostictypeLieutype(DiagnostictypeLieutype $diagnostictypeLieutype): static
    {
        if ($this->diagnostictypeLieutypes->removeElement($diagnostictypeLieutype)) {
            // set the owning side to null (unless already changed)
            if ($diagnostictypeLieutype->getDiagnosticTypeId() === $this) {
                $diagnostictypeLieutype->setDiagnosticTypeId(null);
            }
        }

        return $this;
    }
}
