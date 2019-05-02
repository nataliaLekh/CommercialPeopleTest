<?php
namespace App\Tests\DataFixtures;

use App\Entity\League;
use App\Entity\Team;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadTeamData
 */
class LoadTeamData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $league = new League('tests');
        $team = new Team('tests', 'tests', $league);
        $team2 = new Team('tests2', 'tests2', $league);
        $league->addTeam($team);
        $league->addTeam($team2);

        $manager->persist($league);
        $manager->flush();
    }
}
