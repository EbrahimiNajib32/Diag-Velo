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

    public function __construct()
    {
        $this->id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProprio(): ?string
    {
        return $this->nom_proprio;
    }

    public function setNomProprio(string $nom_proprio): static
    {
        $this->nom_proprio = $nom_proprio;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function addId(velo $id): static
    {
        if (!$this->id->contains($id)) {
            $this->id->add($id);
            $id->setProprietaire($this);
        }

        return $this;
    }

    public function removeId(velo $id): static
    {
        if ($this->id->removeElement($id)) {
            // set the owning side to null (unless already changed)
            if ($id->getProprietaire() === $this) {
                $id->setProprietaire(null);
            }
        }

        return $this;
    }
}
