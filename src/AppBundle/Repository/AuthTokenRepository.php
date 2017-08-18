<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AuthTokenRepository extends EntityRepository
{

    public function findOneByValue($value)
    {

        return $this
            ->createQueryBuilder('at')
            ->select('at')
            ->where('at.value = :value')
            ->setParameter('value', $value)
            ->getQuery()
            ->getOneOrNullResult();

    }

}