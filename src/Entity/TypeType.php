<?php

namespace App\Entity;

use App\Repository\TypeTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeTypeRepository::class)]
class TypeType
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 200, unique: true)]
    private $codeReference;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\JoinColumn(nullable: 'true', name: 'parent_code_reference', referencedColumnName: 'code_reference')]
    #[ORM\ManyToOne(targetEntity: TypeType::class)]
    private $parent;


    public function getCodeReference(): ?string
    {
        return $this->codeReference;
    }

    public function setCodeReference(string $codeReference): static
    {
        $this->codeReference = $codeReference;

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

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }
}
