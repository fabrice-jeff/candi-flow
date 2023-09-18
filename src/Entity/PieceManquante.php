<?php

namespace App\Entity;

use App\Repository\PieceManquanteRepository;
use App\Utils\TraitClasses\EntityTimestampableTrait;
use App\Utils\TraitClasses\EntityUniqueIdTrait;
use App\Utils\TraitClasses\EntityUserOperation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PieceManquanteRepository::class)]
class PieceManquante
{

    use EntityUniqueIdTrait;
    use EntityTimestampableTrait;
    use EntityUserOperation;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPiece = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Candidature $candidature = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPiece(): ?string
    {
        return $this->nomPiece;
    }

    public function setNomPiece(string $nomPiece): static
    {
        $this->nomPiece = $nomPiece;

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
