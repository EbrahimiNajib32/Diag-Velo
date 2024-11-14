<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LieuRepository::class)]
class Lieu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_lieu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse_lieu = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 8)]
    private ?string $code_postal = null;

    #[ORM\ManyToOne(inversedBy: 'lieus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeLieu $type_lieu_id = null;

    /**
     * @var Collection<int, Diagnostic>
     */
    #[ORM\OneToMany(targetEntity: Diagnostic::class, mappedBy: 'Lieu_id')]
    private Collection $diagnostics;

    public function __construct()
    {
        $this->diagnostics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLieu(): ?string
    {
        return $this->nom_lieu;
    }

    public function setNomLieu(string $nom_lieu): static
    {
        $this->nom_lieu = $nom_lieu;

        return $this;
    }

    public function getAdresseLieu(): ?string
    {
        return $this->adresse_lieu;
    }

    public function setAdresseLieu(?string $adresse_lieu): static
    {
        $this->adresse_lieu = $adresse_lieu;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getTypeLieuId(): ?TypeLieu
    {
        return $this->type_lieu_id;
    }

    public function setTypeLieuId(?TypeLieu $type_lieu_id): static
    {
        $this->type_lieu_id = $type_lieu_id;

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
            $diagnostic->setLieuId($this);
        }

        return $this;
    }

    public function removeDiagnostic(Diagnostic $diagnostic): static
    {
        if ($this->diagnostics->removeElement($diagnostic)) {
            // set the owning side to null (unless already changed)
            if ($diagnostic->getLieuId() === $this) {
                $diagnostic->setLieuId(null);
            }
        }

        return $this;
    }
}
