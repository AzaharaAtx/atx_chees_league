<?php

namespace App\Entity;

use App\Repository\RoundRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoundRepository::class)]
class Round
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $id_player = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $id_user = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $id_league = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $soft_delete = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPlayer(): ?int
    {
        return $this->id_player;
    }

    public function setIdPlayer(?int $id_player): static
    {
        $this->id_player = $id_player;

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

    public function getIdLeague(): ?int
    {
        return $this->id_league;
    }

    public function setIdLeague(?int $id_league): static
    {
        $this->id_league = $id_league;

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
