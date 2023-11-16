<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $id_role = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $jwt_token = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $soft_delete = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Role $user_role = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Player $user_player = null;

    #[ORM\Column(length: 255)]
    private ?string $full_name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIdRole(): ?int
    {
        return $this->id_role;
    }

    public function setIdRole(?int $id_role): static
    {
        $this->id_role = $id_role;

        return $this;
    }

    public function getJwtToken(): ?string
    {
        return $this->jwt_token;
    }

    public function setJwtToken(?string $jwt_token): static
    {
        $this->jwt_token = $jwt_token;

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

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getUserRole(): ?Role
    {
        return $this->user_role;
    }

    public function setUserRole(Role $user_role): static
    {
        $this->user_role = $user_role;

        return $this;
    }

    public function getUserPlayer(): ?Player
    {
        return $this->user_player;
    }

    public function setUserPlayer(Player $user_player): static
    {
        $this->user_player = $user_player;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): static
    {
        $this->full_name = $full_name;

        return $this;
    }
}
