<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param int $limit
     * @param int $offset
     *
     * @return mixed
     */
    public function loadAll($limit = 100, $offset = 0)
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->setFirstResult($offset);
        $queryBuilder->setMaxResults($limit);

        return $queryBuilder->getQuery()->execute();
    }

    /**
     * @return int The number of articles stored in MySQL
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function count()
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->select('COUNT(u.id)');

        return (int)$queryBuilder->getQuery()->getSingleScalarResult();
    }
}