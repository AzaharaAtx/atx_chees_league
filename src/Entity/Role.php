<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity
 */
class Role
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="value", type="integer", nullable=true)
     */
    private $value;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="delete", type="boolean", nullable=false)
     */
    private $delete = '0';

    /**
     * @var \User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_role", referencedColumnName="id_user")
     * })
     */
    private $idRole;

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): void
    {
        $this->value = $value;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDelete(): bool|string
    {
        return $this->delete;
    }

    public function setDelete(bool|string $delete): void
    {
        $this->delete = $delete;
    }

    public function getIdRole(): \User
    {
        return $this->idRole;
    }

    public function setIdRole(\User $idRole): void
    {
        $this->idRole = $idRole;
    }


}
