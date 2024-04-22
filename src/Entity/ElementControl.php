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

    #[ORM\Column(length: 255)]
    private ?string $element = null;

    public function getId(): ?int
    {
        return $this->id;
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
