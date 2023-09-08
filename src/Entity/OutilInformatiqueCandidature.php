<?php

namespace App\Entity;

use App\Repository\OutilInformatiqueCandidatureRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OutilInformatiqueCandidatureRepository::class)]
class OutilInformatiqueCandidature
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
    private ?OutilsInformatique $outilInformatique = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Candidature $candidature = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOutilInformatique(): ?OutilsInformatique
    {
        return $this->outilInformatique;
    }

    public function setOutilInformatique(?OutilsInformatique $outilInformatique): static
    {
        $this->outilInformatique = $outilInformatique;

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
}
