<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    /**
     * @param int $limit
     * @param int $offset
     *
     * @return mixed
     */
    public function loadAll($limit = 500, $offset = 0)
    {
        $queryBuilder = $this->createQueryBuilder('a');
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
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder->select('COUNT(a.id)');

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }
}