<?php

namespace App\Entity;

use App\Repository\PosteRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PosteRepository::class)]
class Poste
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

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $ageExige = null;

    #[ORM\Column]
    private ?int $anneeExperiance = null;

    #[ORM\Column(length: 255)]
    private ?string $outilInformatique = null;

    #[ORM\Column(length: 255)]
    private ?string $atoutLangue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $atoutExperiance = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAgeExige(): ?int
    {
        return $this->ageExige;
    }

    public function setAgeExige(?int $ageExige): static
    {
        $this->ageExige = $ageExige;

        return $this;
    }

    public function getAnneeExperiance(): ?int
    {
        return $this->anneeExperiance;
    }

    public function setAnneeExperiance(int $anneeExperiance): static
    {
        $this->anneeExperiance = $anneeExperiance;

        return $this;
    }

    public function getOutilInformatique(): ?string
    {
        return $this->outilInformatique;
    }

    public function setOutilInformatique(string $outilInformatique): static
    {
        $this->outilInformatique = $outilInformatique;

        return $this;
    }

    public function getAtoutLangue(): ?string
    {
        return $this->atoutLangue;
    }

    public function setAtoutLangue(string $atoutLangue): static
    {
        $this->atoutLangue = $atoutLangue;

        return $this;
    }

    public function getAtoutExperiance(): ?string
    {
        return $this->atoutExperiance;
    }

    public function setAtoutExperiance(?string $atoutExperiance): static
    {
        $this->atoutExperiance = $atoutExperiance;

        return $this;
    }
}
