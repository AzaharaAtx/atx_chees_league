<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeGame = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDateGame = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDateGame = null;

    #[ORM\Column(nullable: true)]
    private ?int $classification = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $soft_delete = null;

    #[ORM\OneToOne(inversedBy: 'game', targetEntity: "player", cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(referencedColumnName: "id", nullable: true)]
    private ?Player $winnerGame = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?round $id_round = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?league $id_league = null;

    #[ORM\ManyToMany(targetEntity: player::class, inversedBy: 'games')]
    private Collection $id_player;

    #[ORM\ManyToMany(targetEntity: user::class, inversedBy: 'games')]
    private Collection $id_user;

    public function __construct()
    {
        $this->id_player = new ArrayCollection();
        $this->id_user = new ArrayCollection();
    }


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

    public function getIdLeague(): ?int
    {
        return $this->id_league;
    }

    public function setIdLeague(?int $id_league): static
    {
        $this->id_league = $id_league;

        return $this;
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

    public function getTypeGame(): ?string
    {
        return $this->typeGame;
    }

    public function setTypeGame(?string $typeGame): static
    {
        $this->typeGame = $typeGame;

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

    public function getStartDateGame(): ?\DateTimeInterface
    {
        return $this->startDateGame;
    }

    public function setStartDateGame(?\DateTimeInterface $startDateGame): static
    {
        $this->startDateGame = $startDateGame;

        return $this;
    }

    public function getEndDateGame(): ?\DateTimeInterface
    {
        return $this->endDateGame;
    }

    public function setEndDateGame(?\DateTimeInterface $endDateGame): static
    {
        $this->endDateGame = $endDateGame;

        return $this;
    }

    public function getClassification(): ?int
    {
        return $this->classification;
    }

    public function setClassification(?int $classification): static
    {
        $this->classification = $classification;

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

    public function getWinnerGame(): ?Player
    {
        return $this->winnerGame;
    }

    public function setWinnerGame(?Player $winnerGame): static
    {
        $this->winnerGame = $winnerGame;

        return $this;
    }

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

    public function addIdPlayer(player $idPlayer): static
    {
        if (!$this->id_player->contains($idPlayer)) {
            $this->id_player->add($idPlayer);
        }

        return $this;
    }

    public function removeIdPlayer(player $idPlayer): static
    {
        $this->id_player->removeElement($idPlayer);

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getIdUser(): Collection
    {
        return $this->id_user;
    }

    public function addIdUser(user $idUser): static
    {
        if (!$this->id_user->contains($idUser)) {
            $this->id_user->add($idUser);
        }

        return $this;
    }

    public function removeIdUser(user $idUser): static
    {
        $this->id_user->removeElement($idUser);

        return $this;
    }
}
