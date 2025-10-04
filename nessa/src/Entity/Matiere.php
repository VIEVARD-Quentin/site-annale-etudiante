<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'matieres')]
    #[ORM\JoinColumn(nullable: false, name: 'niveau_id', referencedColumnName: 'id')]
    private ?Niveau $niveau = null;

    #[ORM\OneToMany(mappedBy: 'matiere', targetEntity: Type::class, orphanRemoval: true)]
    private Collection $types;

    public function getId(): ?int { return $this->id; }

    public function getNom(): ?string { return $this->nom; }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getNiveau(): ?Niveau { return $this->niveau; }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;
        return $this;
    }

    public function getType(): Collection { return $this->types; }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types[] = $type;
            $type->setMatiere($this);
        }
        return $this;
    }

    public function removeType(Matiere $type): self
    {
        if ($this->types->removeElement($type)) {
            if ($type->getNiveau() === $this) {
                $type->setNiveau(null);
            }
        }
        return $this;
    }
}
