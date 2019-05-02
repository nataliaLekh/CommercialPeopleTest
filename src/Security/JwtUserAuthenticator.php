<?php
namespace App\Security;

use App\Entity\User;
use App\Util\JwtUtilInterface;
use Exception;
use InvalidArgumentException;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

/**
 * Class JwtUserAuthenticator
 */
class JwtUserAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    /**
     * @var JwtUtilInterface
     */
    private $jwtUtil;

    /**
     * JwtUserAuthenticator constructor.
     *
     * @param JwtUtilInterface $jwtUtil
     */
    public function __construct(JwtUtilInterface $jwtUtil)
    {
        $this->jwtUtil = $jwtUtil;
    }

    /**
     * @param Request $request
     * @param $providerKey
     *
     * @return PreAuthenticatedToken
     */
    public function createToken(Request $request, $providerKey): PreAuthenticatedToken
    {
        $token = $request->headers->get('authorization');
        if (!$token) {
            throw new CustomUserMessageAuthenticationException('Missing token.');
        }

        return new PreAuthenticatedToken('anon.', $token, $providerKey);
    }

    /**
     * @param TokenInterface $token
     * @param $providerKey
     *
     * @return bool
     */
    public function supportsToken(TokenInterface $token, $providerKey): bool
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * @param TokenInterface $token
     * @param UserProviderInterface $userProvider
     * @param $providerKey
     *
     * @return PreAuthenticatedToken
     */
    public function authenticateToken(
        TokenInterface $token,
        UserProviderInterface $userProvider,
        $providerKey
    ): PreAuthenticatedToken {
        if (!$userProvider instanceof JwtUserProvider) {
            throw new InvalidArgumentException('Invalid provider.');
        }

        $tokenData = $this->validateToken($token);

        $user = $userProvider->loadUserByUsername($tokenData->user->username);
        if (!$user instanceof User) {
            throw new CustomUserMessageAuthenticationException('User not found.');
        }

        return new PreAuthenticatedToken($user, $user->getUsername(), $providerKey);
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new Response($exception->getMessageKey(), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param TokenInterface $token
     *
     * @return stdClass
     */
    private function validateToken(TokenInterface $token): stdClass
    {
        preg_match('/^(Bearer )(.*)/', $token->getCredentials(), $matches);
        if (!$matches) {
            throw new CustomUserMessageAuthenticationException('Invalid token.');
        }

        try {
            $tokenData = $this->jwtUtil->decode($matches[2]);
        } catch (Exception $e) {
            throw new CustomUserMessageAuthenticationException('Invalid token.');
        }

        $expiresAt = $tokenData->expires_at;
        if ($expiresAt < \time()) {
            throw new CustomUserMessageAuthenticationException('Token expired.');
        }

        return $tokenData;
    }
}