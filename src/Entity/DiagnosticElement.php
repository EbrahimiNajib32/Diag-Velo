<?php

namespace App\Entity;

use App\Repository\DiagnosticElementRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Diagnostic;
use App\Entity\ElementControl;

#[ORM\Entity(repositoryClass: DiagnosticElementRepository::class)]
class DiagnosticElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_diagnostic = null;

    #[ORM\Column]
    private ?int $id_element = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column]
    private ?int $id_etat = null;

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

    public function getIdElement(): ?int
    {
        return $this->id_element;
    }

    public function setIdElement(int $id_element): static
    {
        $this->id_element = $id_element;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getIdEtat(): ?int
    {
        return $this->id_etat;
    }

    public function setIdEtat(int $id_etat): static
    {
        $this->id_etat = $id_etat;

        return $this;
    }
    
    #[ORM\ManyToOne(targetEntity: Diagnostic::class)]
    #[ORM\JoinColumn(name: "id_diagnostic", referencedColumnName: "id")]
    
    private ?Diagnostic $diagnostic;
    
    #[ORM\ManyToOne(targetEntity: ElementControl::class)]
    #[ORM\JoinColumn(name: "id_element", referencedColumnName: "id")]
    
    private ?ElementControl $elementcontrol;

    #[ORM\ManyToOne(targetEntity: EtatControl::class)]
    #[ORM\JoinColumn(name: "id_etat", referencedColumnName: "id")]
    private ?EtatControl $etatControl;

    public function getEtatControl(): ?EtatControl
    {
        return $this->etatControl;
    }

    public function setEtatControl(?EtatControl $etatControl): self
    {
        $this->etatControl = $etatControl;
        return $this;
    }

    public function getDiagnostic(): ?Diagnostic
    {
    return $this->diagnostic;
    }
    
    public function setDiagnostic(?Diagnostic $diagnostic): static
    {
    $this->diagnostic = $diagnostic;
    return $this;
    }
    
    public function getElementControl(): ?ElementControl
    {
    return $this->elementcontrol;
    }
    
    public function setElementControl(?ElementControl $elementcontrol): static
    {
    $this->elementcontrol = $elementcontrol;
    
    return $this;
    }
    
}
