<?php

namespace App\Entity;

use App\Repository\LeaguePlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: LeaguePlayerRepository::class)]
class LeaguePlayer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?League $id_league_fk = null;

    #[ORM\Column(nullable: true)]
    private ?int $current_points = null;

    #[ORM\Column(nullable: true)]
    private ?int $wins_number = null;

    #[ORM\Column(nullable: true)]
    private ?int $defeats_number = null;

    #[ORM\Column(nullable: true)]
    private ?int $ties_number = null;

    #[ORM\ManyToOne]
    #[MaxDepth(1)]
    private ?User $id_user_fk = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdLeagueFk(): ?League
    {
        return $this->id_league_fk;
    }

    public function setIdLeagueFk(?League $id_league_fk): static
    {
        $this->id_league_fk = $id_league_fk;

        return $this;
    }

    public function getCurrentPoints(): ?int
    {
        return $this->current_points;
    }

    public function setCurrentPoints(?int $current_points): static
    {
        $this->current_points = $current_points;

        return $this;
    }

    public function getWinsNumber(): ?int
    {
        return $this->wins_number;
    }

    public function setWinsNumber(?int $wins_number): static
    {
        $this->wins_number = $wins_number;

        return $this;
    }

    public function getDefeatsNumber(): ?int
    {
        return $this->defeats_number;
    }

    public function setDefeatsNumber(?int $defeats_number): static
    {
        $this->defeats_number = $defeats_number;

        return $this;
    }

    public function getTiesNumber(): ?int
    {
        return $this->ties_number;
    }

    public function setTiesNumber(?int $ties_number): static
    {
        $this->ties_number = $ties_number;

        return $this;
    }

    public function getIdUserFk(): ?User
    {
        return $this->id_user_fk;
    }

    public function setIdUserFk(?User $id_user_fk): static
    {
        $this->id_user_fk = $id_user_fk;

        return $this;
    }

}
