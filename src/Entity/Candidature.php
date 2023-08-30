<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CandidatureRepository;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use App\Utils\TraitClasses\EntityTimestampableTrait;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    use EntityUniqueIdTrait;
    use EntityTimestampableTrait;
    use EntityUserOperation;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nationalite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sexe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDepotDossier = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?NiveauEtude $niveauEtude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $domaine = null;

    #[ORM\Column]
    private ?bool $logicielSpecifique = null;

    #[ORM\Column]
    private ?bool $decision = null;

    #[ORM\Column]
    private ?bool $dossierComplet = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $justification = null;

    #[ORM\ManyToOne]
    private ?Poste $poste = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(?string $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getDateDepotDossier(): ?\DateTimeInterface
    {
        return $this->dateDepotDossier;
    }

    public function setDateDepotDossier(?\DateTimeInterface $dateDepotDossier): static
    {
        $this->dateDepotDossier = $dateDepotDossier;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

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

    public function setDomaine(?string $domaine): static
    {
        $this->domaine = $domaine;

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

    public function isDecision(): ?bool
    {
        return $this->decision;
    }

    public function setDecision(bool $decision): static
    {
        $this->decision = $decision;

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

    public function getJustification(): ?string
    {
        return $this->justification;
    }

    public function setJustification(string $justification): static
    {
        $this->justification = $justification;

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
}
