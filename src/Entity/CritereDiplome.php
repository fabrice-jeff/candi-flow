<?php

namespace App\Entity;

use App\Repository\CritereDiplomeRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CritereDiplomeRepository::class)]
class CritereDiplome
{
    use EntityUniqueIdTrait;
    use EntityTimestampableTrait;
    use EntityUserOperation;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $bareme = null;

    #[ORM\ManyToOne(cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?MatriceEvaluation $matriceEvaluation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $libelle = null;

    #[ORM\ManyToOne]
    private ?Police $police = null;

    #[ORM\Column(length: 255)]
    private ?string $couleurCritere = null;

    #[ORM\Column]
    private ?bool $gras = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMatriceEvaluation(): ?MatriceEvaluation
    {
        return $this->matriceEvaluation;
    }

    public function setMatriceEvaluation(?MatriceEvaluation $matriceEvaluation): static
    {
        $this->matriceEvaluation = $matriceEvaluation;

        return $this;
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

    public function getPolice(): ?Police
    {
        return $this->police;
    }

    public function setPolice(?Police $police): static
    {
        $this->police = $police;

        return $this;
    }

    public function getCouleurCritere(): ?string
    {
        return $this->couleurCritere;
    }

    public function setCouleurCritere(string $couleurCritere): static
    {
        $this->couleurCritere = $couleurCritere;

        return $this;
    }

    public function isGras(): ?bool
    {
        return $this->gras;
    }

    public function setGras(bool $gras): static
    {
        $this->gras = $gras;

        return $this;
    }


}
