<?php

namespace App\Entity;

use App\Repository\LeagueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeagueRepository::class)]
class League
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameLeague = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDateLeague = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDateLeague = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDateParticipate = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $soft_delete = null;

    #[ORM\OneToOne(inversedBy: 'league', targetEntity: "player", cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(referencedColumnName: "id", nullable: true)]
    private ?Player $winnerLeague = null;

    #[ORM\OneToMany(mappedBy: 'id_league', targetEntity: Round::class)]
    private Collection $rounds;

    #[ORM\OneToOne(inversedBy: 'league', cascade: ['persist', 'remove'])]
    private ?round $id_round = null;

    #[ORM\ManyToMany(targetEntity: player::class, inversedBy: 'leagues')]
    private Collection $id_player;

    public function __construct()
    {
        $this->rounds = new ArrayCollection();
        $this->id_player = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRound(): ?int
    {
        return $this->id;
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

    public function getEndDateLeague(): ?\DateTimeInterface
    {
        return $this->endDateLeague;
    }

    public function setEndDateLeague(?\DateTimeInterface $endDateLeague): static
    {
        $this->endDateLeague = $endDateLeague;

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

    public function getWinnerLeague(): ?Player
    {
        return $this->winnerLeague;
    }

    public function setWinnerLeague(?Player $winnerLeague): static
    {
        $this->winnerLeague = $winnerLeague;

        return $this;
    }

    /**
     * @return Collection<int, Round>
     */
    public function getRounds(): Collection
    {
        return $this->rounds;
    }

    public function addRound(Round $round): static
    {
        if (!$this->rounds->contains($round)) {
            $this->rounds->add($round);
            $round->setIdLeague($this);
        }

        return $this;
    }

    public function removeRound(Round $round): static
    {
        if ($this->rounds->removeElement($round)) {
            // set the owning side to null (unless already changed)
            if ($round->getIdLeague() === $this) {
                $round->setIdLeague(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, player>
     */
    public function getIdPlayer(): Collection
    {
        return $this->id_player;
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
     * Obtiene el estado de la liga.
     *
     * @return string|null
     */
    public function getLeagueStatus(): ?string
    {
        if ($this->status === 'active' && $this->startDateLeague <= new \DateTime() && $this->endDateLeague >= new \DateTime()) {
            return 'En curso';
        } elseif ($this->status === 'completed') {
            return 'Completada';
        } else {
            return 'Desconocido';
        }
    }

}
