<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string", length=36, nullable=false)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(name="username", type="string", length=100, nullable=false, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(name="password", type="string", length=100, nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive = true;

    /**
     * @ORM\OneToMany(targetEntity="Token", mappedBy="user", cascade={"persist", "remove"})
     */
    private $tokens;

    /**
     * User constructor.
     *
     * @param string $username
     * @param string|null $password
     *
     * @throws \Exception
     */
    public function __construct(string $username, string $password = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->id = Uuid::uuid4()->toString();
        $this->tokens = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return string|void|null
     */
    public function getSalt()
    {
    }

    /**
     *
     */
    public function eraseCredentials()
    {
    }

    /**
     * @param Token $token
     *
     * @return User
     */
    public function addToken(Token $token): self
    {
        $this->tokens[] = $token;

        return $this;
    }

    /**
     * @param Token $token
     *
     * @return bool
     */
    public function removeToken(Token $token): bool
    {
        return $this->tokens->removeElement($token);
    }

    /**
     * @return Collection
     */
    public function getTokens(): Collection
    {
        return $this->tokens;
    }
}