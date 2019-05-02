<?php
namespace App\Repository;

use App\Entity\League;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class LeagueRepository
 */
class LeagueRepository extends BaseRepository
{
    /**
     * LeagueRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct(League::class, $registry);
    }

    /**
     * Save league
     *
     * @param League $league
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(League $league)
    {
        $this->saveEntity($league);
    }

    /**
     * @param League $league
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(League $league)
    {
        $this->removeEntity($league);
    }
}
