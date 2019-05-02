<?php
namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;

/**
 * Class JwtUser
 */
class JwtUser implements JwtUserInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * JwtUser constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return User
     */
    public function get(): User
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if (!$user instanceof User) {
            throw new TokenNotFoundException('User not found.');
        }

        return $user;
    }
}
