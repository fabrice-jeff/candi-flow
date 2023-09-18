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

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $age = null;
    

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?NiveauEtude $niveauEtude = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $domaine = null;

    #[ORM\Column(nullable:true)]
    private ?int $nombreFormation = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $logicielSpecifique = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Critere $critere = null;

    #[ORM\Column(length: 255)]
    private ?string $dureeParcoursGlobal = null;

    #[ORM\Column(length: 255)]
    private ?string $posteParcoursGlobal = null;

    #[ORM\Column(length: 255)]
    private ?string $dureeParcoursSpecifique = null;

    #[ORM\Column(length: 255)]
    private ?string $posteParcoursSpecifique = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

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

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): static
    {
        $this->age = $age;

        return $this;
    }



    public function getNiveauEtude(): ?NiveauEtude
    {
        return $this->niveauEtude;
    }

    public function setNiveauEtude(?NiveauEtude $niveauEtude): static
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): static
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getNombreFormation(): ?int
    {
        return $this->nombreFormation;
    }

    public function setNombreFormation(int $nombreFormation): static
    {
        $this->nombreFormation = $nombreFormation;

        return $this;
    }

    public function getLogicielSpecifique(): ?string
    {
        return $this->logicielSpecifique;
    }

    public function setLogicielSpecifique(string $logicielSpecifique): static
    {
        $this->logicielSpecifique = $logicielSpecifique;

        return $this;
    }

    public function getCritere(): ?Critere
    {
        return $this->critere;
    }

    public function setCritere(?Critere $critere): static
    {
        $this->critere = $critere;

        return $this;
    }

    public function getDureeParcoursGlobal(): ?string
    {
        return $this->dureeParcoursGlobal;
    }

    public function setDureeParcoursGlobal(string $dureeParcoursGlobal): static
    {
        $this->dureeParcoursGlobal = $dureeParcoursGlobal;

        return $this;
    }

    public function getPosteParcoursGlobal(): ?string
    {
        return $this->posteParcoursGlobal;
    }

    public function setPosteParcoursGlobal(string $posteParcoursGlobal): static
    {
        $this->posteParcoursGlobal = $posteParcoursGlobal;

        return $this;
    }

    public function getDureeParcoursSpecifique(): ?string
    {
        return $this->dureeParcoursSpecifique;
    }

    public function setDureeParcoursSpecifique(string $dureeParcoursSpecifique): static
    {
        $this->dureeParcoursSpecifique = $dureeParcoursSpecifique;

        return $this;
    }

    public function getPosteParcoursSpecifique(): ?string
    {
        return $this->posteParcoursSpecifique;
    }

    public function setPosteParcoursSpecifique(string $posteParcoursSpecifique): static
    {
        $this->posteParcoursSpecifique = $posteParcoursSpecifique;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

}
