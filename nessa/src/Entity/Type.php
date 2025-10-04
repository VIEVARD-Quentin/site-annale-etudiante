<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'types')]
    #[ORM\JoinColumn(nullable: false, name: 'matiere_id', referencedColumnName: 'id')]
    private ?Matiere $matiere = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Annale::class, orphanRemoval: true)]
    private Collection $annales;

    public function __construct()
    {
        $this->annales = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getNom(): ?string { return $this->nom; }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getMatiere(): ?Matiere { return $this->matiere; }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;
        return $this;
    }

    public function getAnnales(): Collection { return $this->annales; }

    public function addAnnale(Annale $annale): self
    {
        if (!$this->annales->contains($annale)) {
            $this->annales[] = $annale;
            $annale->setType($this);
        }
        return $this;
    }

    public function removeAnnale(Annale $annale): self
    {
        if ($this->annales->removeElement($annale)) {
            if ($annale->getType() === $this) {
                $annale->setType(null);
            }
        }
        return $this;
    }
}
