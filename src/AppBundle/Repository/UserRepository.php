<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{

    public function getList($limit, $offset, $order, $keyword)
    {
        $qb = $this
            ->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.name', $order);

        if ($keyword) {
            $qb = $qb
                ->where('u.name LIKE :keyword')
                ->setParameter('keyword', '%' . $keyword . '%');
        }

        $qb = $qb
            ->setFirstResult(($offset - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return $qb;
    }

    public function findOneByMail($mail)
    {
        return $this
            ->createQueryBuilder('u')
            ->select('u')
            ->where('u.mail = :mail')
            ->setParameter('mail', $mail)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
