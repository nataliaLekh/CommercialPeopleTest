<?php
namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class UserRepository
 */
class UserRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct(User::class, $registry);
    }

    /**
     * Save user
     *
     * @param User $user
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(User $user)
    {
        $this->saveEntity($user);
    }
}
