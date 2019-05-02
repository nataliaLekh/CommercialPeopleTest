<?php
namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class JwtUserProvider
 */
class JwtUserProvider implements UserProviderInterface
{
    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;

    /**
     * JwtUserProvider constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $username
     *
     * @return object|UserInterface|null
     */
    public function loadUserByUsername($username)
    {
        return $this->userRepository->findOneBy(['username' => $username]);
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface|void
     */
    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class): bool
    {
        return User::class === $class;
    }
}