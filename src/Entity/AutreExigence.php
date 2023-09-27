<?php

namespace App\Entity;

use App\Repository\AutreExigenceRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AutreExigenceRepository::class)]
class AutreExigence
{
    use EntityUniqueIdTrait;
    use EntityTimestampableTrait;
    use EntityUserOperation;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $bareme = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CritereExigence $critereExigence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getBareme(): ?string
    {
        return $this->bareme;
    }

    public function setBareme(string $bareme): static
    {
        $this->bareme = $bareme;

        return $this;
    }

    public function getCritereExigence(): ?CritereExigence
    {
        return $this->critereExigence;
    }

    public function setCritereExigence(?CritereExigence $critereExigence): static
    {
        $this->critereExigence = $critereExigence;

        return $this;
    }
}
