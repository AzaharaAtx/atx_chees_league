<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Player
 *
 * @ORM\Table(name="player")
 * @ORM\Entity
 */
class Player
{
    /**
     * @var string
     *
     * @ORM\Column(name="user_nameInChess", type="string", length=100, nullable=false)
     */
    private $userNameinchess;

    public function getUserNameinchess(): string
    {
        return $this->userNameinchess;
    }

    public function setUserNameinchess(string $userNameinchess): void
    {
        $this->userNameinchess = $userNameinchess;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getFriendLink(): ?string
    {
        return $this->friendLink;
    }

    public function setFriendLink(?string $friendLink): void
    {
        $this->friendLink = $friendLink;
    }

    public function getEnabled(): int
    {
        return $this->enabled;
    }

    public function setEnabled(int $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getDelete(): bool|string
    {
        return $this->delete;
    }

    public function setDelete(bool|string $delete): void
    {
        $this->delete = $delete;
    }

    public function getLastSeen(): ?\DateTime
    {
        return $this->lastSeen;
    }

    public function setLastSeen(?\DateTime $lastSeen): void
    {
        $this->lastSeen = $lastSeen;
    }

    public function getIdPlayer(): \User
    {
        return $this->idPlayer;
    }

    public function setIdPlayer(\User $idPlayer): void
    {
        $this->idPlayer = $idPlayer;
    }

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone_number", type="string", length=100, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="friend_link", type="string", length=255, nullable=true)
     */
    private $friendLink;

    /**
     * @var int
     *
     * @ORM\Column(name="enabled", type="integer", nullable=false)
     */
    private $enabled;

    /**
     * @var bool
     *
     * @ORM\Column(name="delete", type="boolean", nullable=false)
     */
    private $delete = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_seen", type="datetime", nullable=true)
     */
    private $lastSeen;

    /**
     * @var \User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_player", referencedColumnName="id_user")
     * })
     */
    private $idPlayer;


}
