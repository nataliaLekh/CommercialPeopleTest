<?php
namespace App\Repository;

use App\Entity\Token;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class TokenRepository
 */
class TokenRepository extends BaseRepository
{
    /**
     * TokenRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct(Token::class, $registry);
    }

    /**
     * Save token
     *
     * @param Token $token
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Token $token)
    {
        $this->saveEntity($token);
    }
}
