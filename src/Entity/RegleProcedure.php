<?php

namespace App\Entity;

use App\Repository\RegleProcedureRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegleProcedureRepository::class)]
class RegleProcedure
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
    private ?Poste $poste = null;

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

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): static
    {
        $this->poste = $poste;

        return $this;
    }
}
