<?php

namespace App\Entity;

use App\Repository\LeagueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeagueRepository::class)]
class League
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $id_round = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $id_user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameLeague = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDateLeague = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDateLegue = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDateParticipate = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $soft_delete = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRound(): ?int
    {
        return $this->id_round;
    }

    public function setIdRound(?int $id_round): static
    {
        $this->id_round = $id_round;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(?int $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getNameLeague(): ?string
    {
        return $this->nameLeague;
    }

    public function setNameLeague(?string $nameLeague): static
    {
        $this->nameLeague = $nameLeague;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getStartDateLeague(): ?\DateTimeInterface
    {
        return $this->startDateLeague;
    }

    public function setStartDateLeague(?\DateTimeInterface $startDateLeague): static
    {
        $this->startDateLeague = $startDateLeague;

        return $this;
    }

    public function getEndDateLegue(): ?\DateTimeInterface
    {
        return $this->endDateLegue;
    }

    public function setEndDateLegue(?\DateTimeInterface $endDateLegue): static
    {
        $this->endDateLegue = $endDateLegue;

        return $this;
    }

    public function getEndDateParticipate(): ?\DateTimeInterface
    {
        return $this->endDateParticipate;
    }

    public function setEndDateParticipate(?\DateTimeInterface $endDateParticipate): static
    {
        $this->endDateParticipate = $endDateParticipate;

        return $this;
    }

    public function getSoftDelete(): ?int
    {
        return $this->soft_delete;
    }

    public function setSoftDelete(?int $soft_delete): static
    {
        $this->soft_delete = $soft_delete;

        return $this;
    }
}
