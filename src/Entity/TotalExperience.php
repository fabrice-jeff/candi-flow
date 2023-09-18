<?php

namespace App\Entity;

use App\Repository\TotalExperienceRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TotalExperienceRepository::class)]
class TotalExperience
{
    use EntityUniqueIdTrait;
    use EntityTimestampableTrait;
    use EntityUserOperation;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $poste = null;

    #[ORM\Column(length: 255)]
    private ?string $duree = null;

    #[ORM\Column(length: 255)]
    private ?string $organisme = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Candidature $candidature = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $precisionPoste = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getOrganisme(): ?string
    {
        return $this->organisme;
    }

    public function setOrganisme(string $organisme): static
    {
        $this->organisme = $organisme;

        return $this;
    }

    public function getCandidature(): ?Candidature
    {
        return $this->candidature;
    }

    public function setCandidature(?Candidature $candidature): static
    {
        $this->candidature = $candidature;

        return $this;
    }

    public function getPrecisionPoste(): ?string
    {
        return $this->precisionPoste;
    }

    public function setPrecisionPoste(string $precisionPoste): static
    {
        $this->precisionPoste = $precisionPoste;

        return $this;
    }
}
