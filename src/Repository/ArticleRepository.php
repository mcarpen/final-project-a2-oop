<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    /**
     * @param int  $limit
     * @param int  $offset
     * @param bool $home
     *
     * @return mixed
     */
    public function loadAll($limit = 500, $offset = 0, $home = false)
    {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder->setFirstResult($offset);
        $queryBuilder->setMaxResults($limit);
        if ($home) {
            $queryBuilder->where('a.status = ' . Article::STATUS_PUBLISHED);
            $queryBuilder->orderBy('a.id', 'DESC');
        }

        return $queryBuilder->getQuery()->execute();
    }

    /**
     * @param bool $home
     *
     * @return int The number of articles stored in MySQL
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function count($home = false)
    {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder->select('COUNT(a.id)');
        if ($home) {
            $queryBuilder->where('a.status = ' . Article::STATUS_PUBLISHED);
        }

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }
}