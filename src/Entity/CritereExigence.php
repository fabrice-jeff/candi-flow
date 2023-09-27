<?php

namespace App\Entity;

use App\Repository\CritereExigenceRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CritereExigenceRepository::class)]
class CritereExigence
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
    private ?MatriceEvaluation $matriceEvaluation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AutreInformation $autreInformation = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAutreInformation(): ?AutreInformation
    {
        return $this->autreInformation;
    }

    public function setAutreInformation(?AutreInformation $autreInformation): static
    {
        $this->autreInformation = $autreInformation;

        return $this;
    }


}
