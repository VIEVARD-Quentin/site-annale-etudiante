<?php

namespace App\Entity;

use App\Repository\AnnaleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnaleRepository::class)]
class Annale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $style = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $cheminFichier = null;

    #[ORM\Column(type: 'smallint')]
    private ?int $annee = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateUpload = null;

    #[ORM\ManyToOne(inversedBy: 'annales')]
    #[ORM\JoinColumn(nullable: false, name: 'auteur_id', referencedColumnName: 'id')]
    private ?User $auteur = null;

    #[ORM\ManyToOne(inversedBy: 'annales')]
    #[ORM\JoinColumn(nullable: false, name: 'type_id', referencedColumnName: 'id')]
    private ?Type $type = null;

    public function getId(): ?int { return $this->id; }

    public function getStyle(): ?string { return $this->style; }

    public function setStyle(string $style): self
    {
        $this->style = $style;
        return $this;
    }

    public function getCheminFichier(): ?string { return $this->cheminFichier; }

    public function setCheminFichier(string $cheminFichier): self
    {
        $this->cheminFichier = $cheminFichier;
        return $this;
    }

    public function getAnnee(): ?int { return $this->annee; }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;
        return $this;
    }

    public function getDateUpload(): ?\DateTimeInterface { return $this->dateUpload; }

    public function setDateUpload(\DateTimeInterface $dateUpload): self
    {
        $this->dateUpload = $dateUpload;
        return $this;
    }

    public function getAuteur(): ?User { return $this->auteur; }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;
        return $this;
    }

    public function getType(): ?Type { return $this->type; }

    public function setType(?Type $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }
}
