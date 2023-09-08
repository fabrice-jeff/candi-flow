<?php

namespace App\Entity;

use App\Repository\NiveauEtudeRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NiveauEtudeRepository::class)]
class NiveauEtude
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

    #[ORM\Column]
    private ?bool $domaine = null;

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
    public function __toString(): string
    {
        return $this->getLibelle();
    }

    public function isDomaine(): ?bool
    {
        return $this->domaine;
    }

    public function setDomaine(bool $domaine): static
    {
        $this->domaine = $domaine;

        return $this;
    }
}
