<?php

namespace App\Entity;

use App\Repository\ElementControlRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ElementControlRepository::class)]
class ElementControl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_element = null;

    #[ORM\Column(length: 255)]
    private ?string $element = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getElement(): ?string
    {
        return $this->element;
    }

    public function setElement(string $element): static
    {
        $this->element = $element;

        return $this;
    }
}
