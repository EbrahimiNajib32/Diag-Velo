<?php

namespace App\Entity;

use App\Repository\DiagnosticRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Velo;
use App\Entity\Utilisateur;
use App\Entity\DiagnosticType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: DiagnosticRepository::class)]
class Diagnostic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column]
    private ?int $id_velo = null;

    #[ORM\Column]
    private ?int $id_user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_diagnostic = null;

    #[ORM\Column(nullable: true)]
    private ?int $cout_reparation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conclusion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdDiagnostic(): ?int
    {
        return $this->id;
    }

    public function setIdDiagnostic(int $id): static
    {
        $this->id = $id;

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

    public function getCoutReparation(): ?int
    {
        return $this->cout_reparation;
    }

    public function setCoutReparation(?int $cout_reparation): static
    {
        $this->cout_reparation = $cout_reparation;

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
    
    #[ORM\ManyToOne(targetEntity: Velo::class)]
    #[ORM\JoinColumn(name: "id_velo", referencedColumnName: "id")]
    
    private ?Velo $velo;
    
    
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id")]
    
    private ?Utilisateur $utilisateur;

    #[ORM\OneToMany(targetEntity: DiagnosticElement::class, mappedBy: 'diagnostic', cascade: ['persist', 'remove'])]

    private Collection $diagnosticElements;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;









    #[ORM\ManyToOne(inversedBy: 'id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DiagnosticType $diagnosticType = null;

    #[ORM\ManyToOne(inversedBy: 'diagnostics')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieu $Lieu_id = null;

    #[ORM\ManyToOne(inversedBy: 'diagnostics')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DiagnostictypeLieutype $Diagnostictype_LieuType_id = null;

    public function __construct()
    {
        $this->diagnosticElements = new ArrayCollection();
    }

    public function getDiagnosticElements(): Collection
    {
        return $this->diagnosticElements;
    }

     public function getDiagnosticType(): ?DiagnosticType
    {
        return $this->diagnosticType;
    }

    public function setDiagnosticType(?DiagnosticType $diagnosticType): static
    {
        $this->diagnosticType = $diagnosticType;

        return $this;
    }


    public function addDiagnosticElement(DiagnosticElement $diagnosticElement): self
    {
        if (!$this->diagnosticElements->contains($diagnosticElement)) {
            $this->diagnosticElements[] = $diagnosticElement;
            $diagnosticElement->setDiagnostic($this);
        }

        return $this;
    }

    public function removeDiagnosticElement(DiagnosticElement $diagnosticElement): self
    {
        if ($this->diagnosticElements->removeElement($diagnosticElement)) {
            // Set the owning side to null (unless already changed)
            if ($diagnosticElement->getDiagnostic() === $this) {
                $diagnosticElement->setDiagnostic(null);
            }
        }

        return $this;
    }


    public function getVelo(): ?Velo
    {
    return $this->velo;
    }
    
    public function setVelo(?Velo $velo): static
    {
    $this->velo = $velo;
    return $this;
    }
    
    public function getUtilisateur(): ?Utilisateur
    {
    return $this->utilisateur;
    }
    
    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
    $this->utilisateur = $utilisateur;
    
    return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getLieuId(): ?Lieu
    {
        return $this->Lieu_id;
    }

    public function setLieuId(?Lieu $Lieu_id): static
    {
        $this->Lieu_id = $Lieu_id;

        return $this;
    }

    public function getDiagnostictypeLieuTypeId(): ?DiagnostictypeLieutype
    {
        return $this->Diagnostictype_LieuType_id;
    }

    public function setDiagnostictypeLieuTypeId(?DiagnostictypeLieutype $Diagnostictype_LieuType_id): static
    {
        $this->Diagnostictype_LieuType_id = $Diagnostictype_LieuType_id;

        return $this;
    }

   
    }
