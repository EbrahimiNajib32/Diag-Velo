<?php
namespace App\Entity;

use App\Repository\ProprietaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProprietaireRepository::class)]
class Proprietaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_proprio = null;

    #[ORM\Column]
    private ?int $telephone = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'proprietaire', targetEntity: Velo::class)]
    private Collection $velos;

    public function __construct()
    {
        $this->velos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProprio(): ?string
    {
        return $this->nom_proprio;
    }

    public function setNomProprio(string $nom_proprio): self
    {
        $this->nom_proprio = $nom_proprio;
        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function addVelo(Velo $velo): self
    {
        if (!$this->velos->contains($velo)) {
            $this->velos[] = $velo;
            $velo->setProprietaire($this);
        }
        return $this;
    }

    public function removeVelo(Velo $velo): self
    {
        if ($this->velos->removeElement($velo)) {
            if ($velo->getProprietaire() === $this) {
                $velo->setProprietaire(null);
            }
        }
        return $this;
    }

    // Assurez-vous que les champs pour displayName existent ou ajustez la méthode
    public function displayName(): string
    {
        return $this->nom_proprio; // Simplifiez si vous avez seulement un nom
    }
}
