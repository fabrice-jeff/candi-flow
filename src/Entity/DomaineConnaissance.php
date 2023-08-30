<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use App\Repository\DomaineConnaissanceRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;

#[ORM\Entity(repositoryClass: DomaineConnaissanceRepository::class)]
class DomaineConnaissance
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

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Connaissance $connaissance = null;

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

    public function getConnaissance(): ?Connaissance
    {
        return $this->connaissance;
    }

    public function setConnaissance(?Connaissance $connaissance): static
    {
        $this->connaissance = $connaissance;

        return $this;
    }
}
