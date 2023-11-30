<?php

namespace App\Entity;

use App\Repository\RoundRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoundRepository::class)]
class Round
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'round', targetEntity: "player", cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(referencedColumnName: "id", nullable: true)]
    private ?Player $winnerRound = null;

    #[ORM\ManyToMany(targetEntity: player::class, inversedBy: 'rounds')]
    private Collection $id_player;

    #[ORM\ManyToOne(inversedBy: 'rounds')]
    private ?league $id_league = null;

    #[ORM\ManyToMany(targetEntity: user::class, inversedBy: 'rounds')]
    private Collection $id_user;

    #[ORM\OneToOne(mappedBy: 'id_round', cascade: ['persist', 'remove'])]
    private ?League $league = null;

    public function __construct()
    {
        $this->id_player = new ArrayCollection();
        $this->id_user = new ArrayCollection();
    }

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

    public function getWinnerRound(): ?Player
    {
        return $this->winnerRound;
    }

    public function setWinnerRound(?Player $winnerRound): static
    {
        $this->winnerRound = $winnerRound;

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

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeague(?League $league): static
    {
        // unset the owning side of the relation if necessary
        if ($league === null && $this->league !== null) {
            $this->league->setIdRound(null);
        }

        // set the owning side of the relation if necessary
        if ($league !== null && $league->getIdRound() !== $this) {
            $league->setIdRound($this);
        }

        $this->league = $league;

        return $this;
    }
}
