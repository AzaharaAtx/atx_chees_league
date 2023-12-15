<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $soft_delete = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Round $id_round_fk = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $white_player_fk = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $black_player_fk = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    public function getIdRoundFk(): ?Round
    {
        return $this->id_round_fk;
    }

    public function setIdRoundFk(?Round $id_round_fk): static
    {
        $this->id_round_fk = $id_round_fk;

        return $this;
    }

    public function getWhitePlayerFk(): ?Player
    {
        return $this->white_player_fk;
    }

    public function setWhitePlayerFk(Player $white_player_fk): static
    {
        $this->white_player_fk = $white_player_fk;

        return $this;
    }

    public function getBlackPlayerFk(): ?Player
    {
        return $this->black_player_fk;
    }

    public function setBlackPlayerFk(Player $black_player_fk): static
    {
        $this->black_player_fk = $black_player_fk;

        return $this;
    }
}
