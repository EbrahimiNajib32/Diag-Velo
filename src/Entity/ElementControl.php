<?php

namespace App\Entity;

use App\Repository\ElementControlRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, DiagnosticType>
     */
    #[ORM\ManyToMany(targetEntity: DiagnosticType::class, mappedBy: 'id')]
    private Collection $diagnosticTypes;

    public function __construct()
    {
        $this->diagnosticTypes = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, DiagnosticType>
     */
    public function getDiagnosticTypes(): Collection
    {
        return $this->diagnosticTypes;
    }

    public function addDiagnosticType(DiagnosticType $diagnosticType): static
    {
        if (!$this->diagnosticTypes->contains($diagnosticType)) {
            $this->diagnosticTypes->add($diagnosticType);
            $diagnosticType->addId($this);
        }

        return $this;
    }

    public function removeDiagnosticType(DiagnosticType $diagnosticType): static
    {
        if ($this->diagnosticTypes->removeElement($diagnosticType)) {
            $diagnosticType->removeId($this);
        }

        return $this;
    }
}
