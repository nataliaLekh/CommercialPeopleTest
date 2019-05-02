<?php
namespace App\Service;

use App\Entity\Token;
use App\Entity\User;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use App\Util\JwtUtilInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserService
 */
class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var TokenRepository
     */
    private $tokenRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     *  @var JwtUtilInterface
     */
    private $jwtUtil;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     * @param TokenRepository $tokenRepository
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param JwtUtilInterface $jwtUtil
     */
    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $userPasswordEncoder,
        JwtUtilInterface $jwtUtil,
        TokenRepository $tokenRepository
    ) {
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->jwtUtil = $jwtUtil;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws \Exception
     */
    public function login(string $username, string $password): array
    {
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['username' => $username]);
        if (!$user instanceof User || !$this->userPasswordEncoder->isPasswordValid($user, $password)) {
            throw new UnauthorizedHttpException('Basic realm="API Login"', 'Invalid credentials.');
        }
        $expiresAt = \time() + Token::TOKEN_EXPIRATION_DATE;
        $tokenData = [
            'expires_at' => $expiresAt,
            'user' => [
                'username' => $user->getUsername(),
                'password' => $user->getPassword()
            ]
        ];

        $token = new Token($user, $this->jwtUtil->encode($tokenData), $expiresAt);
        $this->tokenRepository->save($token);

        return [
            'username' => $user->getUsername(),
            'token' => $token->data()
        ];
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws \Exception
     *
     * @return array
     */
    public function register(string $username, string $password): array
    {
        $user = new User($username);
        $password = $this->userPasswordEncoder->encodePassword($user, $password);
        $user->setPassword($password);

        $expiresAt = \time() + Token::TOKEN_EXPIRATION_DATE;
        $tokenData = [
            'expires_at' => $expiresAt,
            'user' => [
                'username' => $user->getUsername(),
                'password' => $user->getPassword()
            ]
        ];

        $token = new Token($user, $this->jwtUtil->encode($tokenData), $expiresAt);
        $user->addToken($token);
        $this->userRepository->save($user);

        return [
            'username' => $user->getUsername(),
            'token' => $token->data()
        ];
    }
}
