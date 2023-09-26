<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AutreInformationRepository;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use App\Utils\TraitClasses\EntityTimestampableTrait;

#[ORM\Entity(repositoryClass: AutreInformationRepository::class)]
class AutreInformation
{
    use EntityUniqueIdTrait;
    use EntityTimestampableTrait;
    use EntityUserOperation;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomColonne = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $information = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Poste $poste = null;


    #[ORM\ManyToOne(targetEntity: TypeType::class)]
    #[ORM\JoinColumn(name:"code_reference", referencedColumnName:"code_reference")]
    private $typeType;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomColonne(): ?string
    {
        return $this->nomColonne;
    }

    public function setNomColonne(string $nomColonne): static
    {
        $this->nomColonne = $nomColonne;

        return $this;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(string $information): static
    {
        $this->information = $information;

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


    public function getTypeType() {
        return $this->typeType;
    }

    public function setTypeType($typeType) {
        $this->typeType = $typeType;
        return $this;
    }


}
