<?php
namespace App\Tests\Unit\Service;

use App\Entity\User;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use App\Tests\BaseTest;
use App\Util\JwtUtil;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class UserServiceTest
 */
class UserServiceTest extends BaseTest
{
    public function setUp()
    {
        parent::setUp();
        $this->mockAllInjections();
    }

    /**
     * Mock all service in tested class.
     */
    public function mockAllInjections()
    {
        $this->injectServiceMock(UserRepository::class);
        $this->injectServiceMock('security.user_password_encoder.generic');
        $this->injectServiceMock(JwtUtil::class);
        $this->injectServiceMock(TokenRepository::class);
    }

    /**
     * Function: login
     * Conditions: Success
     */
    public function testLoginSuccess()
    {
        $user = new User('natalia','123123');

        /** @var \PHPUnit_Framework_MockObject_MockObject $userRepository */
        $userRepository = $this->getService(UserRepository::class);
        $userRepository->method('findOneBy')->willReturn($user);

        /** @var \PHPUnit_Framework_MockObject_MockObject $userPasswordEncoder */
        $userPasswordEncoder = $this->getService('security.user_password_encoder.generic');
        $userPasswordEncoder->method('isPasswordValid')->willReturn(true);

        /** @var \PHPUnit_Framework_MockObject_MockObject $tokenRepository */
        $tokenRepository = $this->getService(TokenRepository::class);
        $tokenRepository->method('save')->willReturn(true);

        /** @var UserService $userService */
        $userService = $this->getService(UserService::class);
        $user = $userService->login('test', 'test');

        $this->assertEquals('natalia', $user['username']);
    }

    /**
     * Function: login
     * Conditions: Error
     */
    public function testLoginUnauthorizedError()
    {
        $this->expectException(UnauthorizedHttpException::class);
        $message = 'Invalid credentials.';
        $this->expectExceptionMessage($message);

        /** @var \PHPUnit_Framework_MockObject_MockObject $userRepository */
        $userRepository = $this->getService(UserRepository::class);
        $userRepository->method('findOneBy')->willReturn(null);

        /** @var UserService $userService */
        $userService = $this->getService(UserService::class);
        $userService->login('test', 'test');
    }

    /**
     * Function: register
     * Conditions: Success
     */
    public function testRegisterSuccess()
    {
        $hashPassword = '$2y$13$bTeKBrQPMn6kQyToxYxHoemJfb33MsMqvQuFoGttD4lon3072aNxq';

        /** @var \PHPUnit_Framework_MockObject_MockObject $userPasswordEncoder */
        $userPasswordEncoder = $this->getService('security.user_password_encoder.generic');
        $userPasswordEncoder->method('encodePassword')->willReturn($hashPassword);

        /** @var \PHPUnit_Framework_MockObject_MockObject $jwtUtil */
        $jwtUtil = $this->getService(JwtUtil::class);
        $jwtUtil->method('encode')->willReturn(true);

        /** @var \PHPUnit_Framework_MockObject_MockObject $userRepository */
        $userRepository = $this->getService(UserRepository::class);
        $userRepository->method('save')->willReturn(true);

        /** @var UserService $userService */
        $userService = $this->getService(UserService::class);
        $user = $userService->register('natalia', '123123');

        $this->assertEquals('natalia', $user['username']);
    }
}
