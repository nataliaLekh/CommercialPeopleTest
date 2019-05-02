<?php
namespace App\Tests\DataFixtures;

use App\Entity\Token;
use App\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 1;
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $user = new User('natalia');
        $hashPassword = $this->container->getParameter('password_test');
        $user->setPassword($hashPassword);
        $manager->persist($user);
        $manager->flush();

        $expiresAt = \time() + Token::TOKEN_EXPIRATION_DATE;
        $hashToken = $this->container->getParameter('jwt_test_key');
        $token = new Token($user, $hashToken, $expiresAt);
        $manager->persist($token);
        $manager->flush();
    }
}
