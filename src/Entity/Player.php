<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username_in_chess = null;

    #[ORM\Column(nullable: true)]
    private ?int $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $friend_link = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $soft_delete = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $last_seen = null;

    #[ORM\OneToOne(mappedBy: 'user_player', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(referencedColumnName: "id", nullable: true)]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'winnerLeague', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(referencedColumnName: "id", nullable: true)]
    private ?League $league = null;

    #[ORM\OneToOne(mappedBy: 'winnerGame', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(referencedColumnName: "id", nullable: true)]
    private ?Game $game = null;

    /**
     * @var Collection|ArrayCollection
     * Permiten manipular, gestionar y representar las asociaciones
     * entre entidades.
     * https://www.doctrine-project.org/projects/doctrine-collections/en/stable/index.html#collection-methods
     * 
     */

    #[ORM\ManyToMany(targetEntity: Round::class, mappedBy: 'id_player')]
    private Collection $rounds;

    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'id_player')]
    private Collection $games;

    #[ORM\ManyToMany(targetEntity: League::class, mappedBy: 'id_player')]
    private Collection $leagues;

    #[ORM\ManyToMany(targetEntity: League::class, mappedBy: 'username')]
    private Collection $leagues_nick;

    public function __construct()
    {
        $this->rounds = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->leagues = new ArrayCollection();
        $this->leagues_nick = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsernameInChess(): ?string
    {
        return $this->username_in_chess;
    }

    public function setUsernameInChess(string $username_in_chess): static
    {
        $this->username_in_chess = $username_in_chess;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFriendLink(): ?string
    {
        return $this->friend_link;
    }

    public function setFriendLink(?string $friend_link): static
    {
        $this->friend_link = $friend_link;

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

    public function getLastSeen(): ?\DateTimeInterface
    {
        return $this->last_seen;
    }

    public function setLastSeen(?\DateTimeInterface $last_seen): static
    {
        $this->last_seen = $last_seen;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        // set the owning side of the relation if necessary
        if ($user->getUserPlayer() !== $this) {
            $user->setUserPlayer($this);
        }

        $this->user = $user;

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
            $this->league->setWinnerLeague(null);
        }

        // set the owning side of the relation if necessary
        if ($league !== null && $league->getWinnerLeague() !== $this) {
            $league->setWinnerLeague($this);
        }

        $this->league = $league;

        return $this;
    }

    public function getRound(): ?Round
    {
        return $this->round;
    }

    public function setRound(?Round $round): static
    {
        // unset the owning side of the relation if necessary
        if ($round === null && $this->round !== null) {
            $this->round->setWinnerRound(null);
        }

        // set the owning side of the relation if necessary
        if ($round !== null && $round->getWinnerRound() !== $this) {
            $round->setWinnerRound($this);
        }

        $this->round = $round;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        // unset the owning side of the relation if necessary
        if ($game === null && $this->game !== null) {
            $this->game->setWinnerGame(null);
        }

        // set the owning side of the relation if necessary
        if ($game !== null && $game->getWinnerGame() !== $this) {
            $game->setWinnerGame($this);
        }

        $this->game = $game;

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
            $round->addIdPlayer($this);
        }

        return $this;
    }

    public function removeRound(Round $round): static
    {
        if ($this->rounds->removeElement($round)) {
            $round->removeIdPlayer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->addIdPlayer($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->games->removeElement($game)) {
            $game->removeIdPlayer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, League>
     */
    public function getLeagues(): Collection
    {
        return $this->leagues;
    }

    public function addLeague(League $league): static
    {
        if (!$this->leagues->contains($league)) {
            $this->leagues->add($league);
            $league->addIdPlayer($this);
        }

        return $this;
    }

    public function removeLeague(League $league): static
    {
        if ($this->leagues->removeElement($league)) {
            $league->removeIdPlayer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, League>
     */
    public function getLeaguesNick(): Collection
    {
        return $this->leagues_nick;
    }

    public function addLeaguesNick(League $leaguesNick): static
    {
        if (!$this->leagues_nick->contains($leaguesNick)) {
            $this->leagues_nick->add($leaguesNick);
            $leaguesNick->addUsername($this);
        }

        return $this;
    }

    public function removeLeaguesNick(League $leaguesNick): static
    {
        if ($this->leagues_nick->removeElement($leaguesNick)) {
            $leaguesNick->removeUsername($this);
        }

        return $this;
    }
}
