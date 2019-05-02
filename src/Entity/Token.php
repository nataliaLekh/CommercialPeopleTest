<?php
namespace App\Entity;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TokenRepository")
 * @ORM\Table(name="tokens")
 */
class Token implements EntityInterface
{
    const TOKEN_EXPIRATION_DATE = 1209600; // Two weeks

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string", length=36, nullable=false)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(name="data", type="text", nullable=false)
     */
    private $data;

    /**
     * @ORM\Column(name="created_at", type="string", length=30, nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(name="expires_at", type="string", length=30, nullable=false)
     */
    private $expiresAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tokens", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;

    /**
     * Token constructor.
     *
     * @param User $user
     * @param string $data
     * @param int $expiresAt
     *
     * @throws \Exception
     */
    public function __construct(User $user, string $data, int $expiresAt)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->data = $data;
        $this->createdAt = \time();
        $this->expiresAt = $expiresAt;
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function data(): string
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function createdAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function expiresAt(): string
    {
        return $this->expiresAt;
    }

    /**
     * @return User
     */
    public function user(): User
    {
        return $this->user;
    }
}