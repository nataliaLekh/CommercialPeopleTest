<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\EntityInterface;

/**
 * Class BaseRepository
 */
class BaseRepository extends ServiceEntityRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param string $entityClass
     * @param RegistryInterface $registry
     */
    public function __construct($entityClass, RegistryInterface $registry)
    {
        parent::__construct($registry, $entityClass);
    }

    /**
     * @param EntityInterface $entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveEntity(EntityInterface $entity)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * @param EntityInterface $entity
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeEntity(EntityInterface $entity)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($entity);
        $entityManager->flush();
    }

    public function startTransaction()
    {
        $this->getEntityManager()->beginTransaction();
    }

    public function commitTransaction()
    {
        $this->getEntityManager()->commit();
    }

    public function rollbackTransaction()
    {
        $this->getEntityManager()->rollback();
    }
}
