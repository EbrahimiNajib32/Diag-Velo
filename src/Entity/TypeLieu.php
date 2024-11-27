<?php

namespace App\Entity;

use App\Repository\TypeLieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeLieuRepository::class)]
class TypeLieu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_type_lieu = null;

    #[ORM\Column]
    private ?bool $actif = null;

    /**
     * @var Collection<int, Lieu>
     */
    #[ORM\OneToMany(targetEntity: Lieu::class, mappedBy: 'type_lieu_id')]
    private Collection $lieus;

    /**
     * @var Collection<int, DiagnostictypeLieutype>
     */
    #[ORM\OneToMany(targetEntity: DiagnostictypeLieutype::class, mappedBy: 'Lieu_type_id')]
    private Collection $diagnostictypeLieutypes;

    public function __construct()
    {
        $this->lieus = new ArrayCollection();
        $this->diagnostictypeLieutypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeLieu(): ?string
    {
        return $this->nom_type_lieu;
    }

    public function setNomTypeLieu(string $nom_type_lieu): static
    {
        $this->nom_type_lieu = $nom_type_lieu;

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
     * @return Collection<int, Lieu>
     */
    public function getLieus(): Collection
    {
        return $this->lieus;
    }

    public function addLieu(Lieu $lieu): static
    {
        if (!$this->lieus->contains($lieu)) {
            $this->lieus->add($lieu);
            $lieu->setTypeLieuId($this);
        }

        return $this;
    }

    public function removeLieu(Lieu $lieu): static
    {
        if ($this->lieus->removeElement($lieu)) {
            // set the owning side to null (unless already changed)
            if ($lieu->getTypeLieuId() === $this) {
                $lieu->setTypeLieuId(null);
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
            $diagnostictypeLieutype->setLieuTypeId($this);
        }

        return $this;
    }

    public function removeDiagnostictypeLieutype(DiagnostictypeLieutype $diagnostictypeLieutype): static
    {
        if ($this->diagnostictypeLieutypes->removeElement($diagnostictypeLieutype)) {
            // set the owning side to null (unless already changed)
            if ($diagnostictypeLieutype->getLieuTypeId() === $this) {
                $diagnostictypeLieutype->setLieuTypeId(null);
            }
        }

        return $this;
    }
}
