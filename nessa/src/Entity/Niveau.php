<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'niveaux')]
    #[ORM\JoinColumn(nullable: false, name: 'formation_id', referencedColumnName: 'id')]
    private ?Formation $formation = null;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: Matiere::class, orphanRemoval: true)]
    private Collection $matieres;

    public function __construct()
    {
        $this->matieres = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getNom(): ?string { return $this->nom; }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getFormation(): ?Formation { return $this->formation; }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;
        return $this;
    }

    public function getMatieres(): Collection { return $this->matieres; }

    public function addMatiere(Matiere $matiere): self
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres[] = $matiere;
            $matiere->setNiveau($this);
        }
        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        if ($this->matieres->removeElement($matiere)) {
            if ($matiere->getNiveau() === $this) {
                $matiere->setNiveau(null);
            }
        }
        return $this;
    }
}
