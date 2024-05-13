<?php

namespace App\Entity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VeloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Diagnostic; // Import de l'entité Diagnostic si ce n'est pas déjà fait
#[ORM\Entity(repositoryClass: VeloRepository::class)]
class Velo
{

    public function removeDiagnostic(Diagnostic $diagnostic): self
    {
        if ($this->diagnostics->removeElement($diagnostic)) {
            // set the owning side to null (unless already changed)
            if ($diagnostic->getVelo() === $this) {
                $diagnostic->setVelo(null);
            }
        }

        return $this;
    }


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_de_serie = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column(nullable: true)]
    private ?int $ref_recyclerie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $couleur = null;

    #[ORM\Column(nullable: true)]
    private ?int $poids = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $taille_roues = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $taille_cadre = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\Column(length: 255)]
    private ?string $url_photo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_de_enregistrement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_de_vente = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;


    #[ORM\Column(length: 255)]
    private ?string $emplacement = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentaire = null;
//
//     #[ORM\ManyToOne(inversedBy: 'proprietaire')]
//     #[ORM\JoinColumn(nullable: false)]
//     private ?Proprietaire $proprietaire = null;

#[ORM\ManyToOne(inversedBy: 'velos')]
#[ORM\JoinColumn(nullable: false)]
private ?Proprietaire $proprietaire = null;

#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
private ?\DateTimeInterface $date_destruction = null;

#[ORM\Column(length: 255, nullable: true)]
private ?string $public = null;


 #[ORM\Column(type: "string", length: 255, nullable: true)]
   private ?string $origine = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroDeSerie(): ?string
    {
        return $this->numero_de_serie;
    }

    public function setNumeroDeSerie(string $numero_de_serie): static
    {
        $this->numero_de_serie = $numero_de_serie;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getRefRecyclerie(): ?int
    {
        return $this->ref_recyclerie;
    }

    public function setRefRecyclerie(?int $ref_recyclerie): static
    {
        $this->ref_recyclerie = $ref_recyclerie;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(?int $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getTailleRoues(): ?string
    {
        return $this->taille_roues;
    }

    public function setTailleRoues(string $taille_roues): static
    {
        $this->taille_roues = $taille_roues;

        return $this;
    }

    public function getTailleCadre(): ?string
    {
        return $this->taille_cadre;
    }

    public function setTailleCadre(string $taille_cadre): static
    {
        $this->taille_cadre = $taille_cadre;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getUrlPhoto(): ?string
    {
        return $this->url_photo;
    }

    public function setUrlPhoto(string $url_photo): static
    {
        $this->url_photo = $url_photo;

        return $this;
    }

    public function getDateDeEnregistrement(): ?\DateTimeInterface
    {
        return $this->date_de_enregistrement;
    }

    public function setDateDeEnregistrement(\DateTimeInterface $date_de_enregistrement): static
    {
        $this->date_de_enregistrement = $date_de_enregistrement;

        return $this;
    }


    public function getDateDeVente(): ?\DateTimeInterface
    {
        return $this->date_de_vente;
    }


    public function setDateDeVente($date_de_vente): self
    {
        if (is_string($date_de_vente)) {
            try {
                $date_de_vente = new \DateTime($date_de_vente);
            } catch (\Exception $e) {
                throw new \InvalidArgumentException("Date de vente invalide : " . $e->getMessage());
            }
        }
        $this->date_de_vente = $date_de_vente;
        return $this;
    }


    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): static
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getProprietaire(): ?Proprietaire
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Proprietaire $proprietaire): static
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getDateDestruction(): ?\DateTimeInterface
    {
        return $this->date_destruction;
    }

    public function setDateDestruction($date_destruction): self
    {
        if (is_string($date_destruction)) {
            $this->date_destruction = new \DateTime($date_destruction);
        } else {
            $this->date_destruction = $date_destruction;
        }
        return $this;
    }

    public function getPublic(): ?string
    {
        return $this->public;
    }

    public function setPublic(?string $public): static
    {
        $this->public = $public;

        return $this;
    }

 public function getOrigine(): ?string
        {
            return $this->origine;
        }

        public function setOrigine(?string $origine): self
        {
            $this->origine = $origine;
            return $this;
        }

}
