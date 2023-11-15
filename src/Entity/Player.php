<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
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
    private ?User $user = null;

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
}
