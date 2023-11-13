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
