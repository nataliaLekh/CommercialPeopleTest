<?php
namespace App\Repository;

use App\Entity\Team;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class TeamRepository
 */
class TeamRepository extends BaseRepository
{
    /**
     * TeamRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct(Team::class, $registry);
    }

    /**
     * Save team
     *
     * @param Team $team
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Team $team)
    {
        $this->saveEntity($team);
    }
}
