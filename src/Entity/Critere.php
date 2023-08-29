<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CritereRepository;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use App\Utils\TraitClasses\EntityTimestampableTrait;

#[ORM\Entity(repositoryClass: CritereRepository::class)]
class Critere
{

    use EntityUniqueIdTrait;
    use EntityTimestampableTrait;
    use EntityUserOperation;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $nomPrenoms = null;

    #[ORM\Column]
    private ?bool $nationalite = null;

    #[ORM\Column]
    private ?bool $dateNissance = null;

    #[ORM\Column]
    private ?bool $contact = null;

    #[ORM\Column]
    private ?bool $email = null;

    #[ORM\Column]
    private ?bool $sexe = null;

    #[ORM\Column]
    private ?bool $ageExige = null;

    #[ORM\Column]
    private ?bool $dateDepotDossier = null;

    #[ORM\Column]
    private ?bool $diplome = null;

    #[ORM\Column]
    private ?bool $autreFormation = null;

    #[ORM\Column]
    private ?bool $logicielSpecifique = null;

    #[ORM\Column]
    private ?bool $autreOutils = null;

    #[ORM\Column]
    private ?bool $totalExperiance = null;

    #[ORM\Column]
    private ?bool $parcoursGlobal = null;

    #[ORM\Column]
    private ?bool $parcoursSpecifique = null;

    #[ORM\Column]
    private ?bool $connaissance = null;

    #[ORM\Column]
    private ?bool $atout = null;

    #[ORM\Column]
    private ?bool $dicision = null;

    #[ORM\Column]
    private ?bool $dossierComplet = null;

    #[ORM\Column]
    private ?bool $justification = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isNomPrenoms(): ?bool
    {
        return $this->nomPrenoms;
    }

    public function setNomPrenoms(bool $nomPrenoms): static
    {
        $this->nomPrenoms = $nomPrenoms;

        return $this;
    }

    public function isNationalite(): ?bool
    {
        return $this->nationalite;
    }

    public function setNationalite(bool $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function isDateNissance(): ?bool
    {
        return $this->dateNissance;
    }

    public function setDateNissance(bool $dateNissance): static
    {
        $this->dateNissance = $dateNissance;

        return $this;
    }

    public function isContact(): ?bool
    {
        return $this->contact;
    }

    public function setContact(bool $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function isEmail(): ?bool
    {
        return $this->email;
    }

    public function setEmail(bool $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function isSexe(): ?bool
    {
        return $this->sexe;
    }

    public function setSexe(bool $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function isAgeExige(): ?bool
    {
        return $this->ageExige;
    }

    public function setAgeExige(bool $ageExige): static
    {
        $this->ageExige = $ageExige;

        return $this;
    }

    public function isDateDepotDossier(): ?bool
    {
        return $this->dateDepotDossier;
    }

    public function setDateDepotDossier(bool $dateDepotDossier): static
    {
        $this->dateDepotDossier = $dateDepotDossier;

        return $this;
    }

    public function isDiplome(): ?bool
    {
        return $this->diplome;
    }

    public function setDiplome(bool $diplome): static
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function isAutreFormation(): ?bool
    {
        return $this->autreFormation;
    }

    public function setAutreFormation(bool $autreFormation): static
    {
        $this->autreFormation = $autreFormation;

        return $this;
    }

    public function isLogicielSpecifique(): ?bool
    {
        return $this->logicielSpecifique;
    }

    public function setLogicielSpecifique(bool $logicielSpecifique): static
    {
        $this->logicielSpecifique = $logicielSpecifique;

        return $this;
    }

    public function isAutreOutils(): ?bool
    {
        return $this->autreOutils;
    }

    public function setAutreOutils(bool $autreOutils): static
    {
        $this->autreOutils = $autreOutils;

        return $this;
    }

    public function isTotalExperiance(): ?bool
    {
        return $this->totalExperiance;
    }

    public function setTotalExperiance(bool $totalExperiance): static
    {
        $this->totalExperiance = $totalExperiance;

        return $this;
    }

    public function isParcoursGlobal(): ?bool
    {
        return $this->parcoursGlobal;
    }

    public function setParcoursGlobal(bool $parcoursGlobal): static
    {
        $this->parcoursGlobal = $parcoursGlobal;

        return $this;
    }

    public function isParcoursSpecifique(): ?bool
    {
        return $this->parcoursSpecifique;
    }

    public function setParcoursSpecifique(bool $parcoursSpecifique): static
    {
        $this->parcoursSpecifique = $parcoursSpecifique;

        return $this;
    }

    public function isConnaissance(): ?bool
    {
        return $this->connaissance;
    }

    public function setConnaissance(bool $connaissance): static
    {
        $this->connaissance = $connaissance;

        return $this;
    }

    public function isAtout(): ?bool
    {
        return $this->atout;
    }

    public function setAtout(bool $atout): static
    {
        $this->atout = $atout;

        return $this;
    }

    public function isDicision(): ?bool
    {
        return $this->dicision;
    }

    public function setDicision(bool $dicision): static
    {
        $this->dicision = $dicision;

        return $this;
    }

    public function isDossierComplet(): ?bool
    {
        return $this->dossierComplet;
    }

    public function setDossierComplet(bool $dossierComplet): static
    {
        $this->dossierComplet = $dossierComplet;

        return $this;
    }

    public function isJustification(): ?bool
    {
        return $this->justification;
    }

    public function setJustification(bool $justification): static
    {
        $this->justification = $justification;

        return $this;
    }
}
