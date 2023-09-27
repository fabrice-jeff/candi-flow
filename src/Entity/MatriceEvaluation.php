<?php

namespace App\Entity;

use App\Repository\MatriceEvaluationRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatriceEvaluationRepository::class)]
class MatriceEvaluation
{
    use EntityUniqueIdTrait;
    use EntityTimestampableTrait;
    use EntityUserOperation;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Poste $poste = null;

    #[ORM\Column]
    private ?bool $critereAtout = null;

    #[ORM\Column]
    private ?bool $critereExigence = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function isCritereAtout(): ?bool
    {
        return $this->critereAtout;
    }

    public function setCritereAtout(bool $critereAtout): static
    {
        $this->critereAtout = $critereAtout;

        return $this;
    }

    public function isCritereExigence(): ?bool
    {
        return $this->critereExigence;
    }

    public function setCritereExigence(bool $critereExigence): static
    {
        $this->critereExigence = $critereExigence;

        return $this;
    }
}
