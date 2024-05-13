<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface , PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $role = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword($password): static
    {
        $this->password = $password;

        return $this;
    }
    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }
    public function eraseCredentials(): void
    {

    }
    public function getRoles(): array
    {
        $roles = [];

        $roles[] = 'ROLE_USER';

        if ($this->role === 0) {
            $roles[] = 'ROLE_ADMIN';
        } elseif ($this->role === 1) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function getUserIdentifier(): string
    {
        return $this->nom;
    }

    public function getSalt(): ?string
    {
        return null;
    }
}
