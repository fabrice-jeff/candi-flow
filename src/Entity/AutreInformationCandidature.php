<?php

namespace App\Entity;

use App\Repository\AutreInformationCandidatureRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AutreInformationCandidatureRepository::class)]
class AutreInformationCandidature
{
//    use EntityUniqueIdTrait;
//    use EntityTimestampableTrait;
//    use EntityUserOperation;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AutreInformation $autreInformation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Candidature $candidature = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAutreInformation(): ?AutreInformation
    {
        return $this->autreInformation;
    }

    public function setAutreInformation(?AutreInformation $autreInformation): static
    {
        $this->autreInformation = $autreInformation;

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
