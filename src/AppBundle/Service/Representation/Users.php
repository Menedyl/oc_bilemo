<?php

namespace AppBundle\Service\Representation;


use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;

class Users
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function paginate($users, ParamFetcherInterface $paramFetcher)
    {
        $totalUsers = count($this->em->getRepository('AppBundle:User')->findAll());
        $totalPages = ceil($totalUsers / $paramFetcher->get('limit'));

        $representationUsers =
            new PaginatedRepresentation(
                new CollectionRepresentation(
                    $users,
                    'users'
                ),
                'users_list',
                [],
                $paramFetcher->get('offset'),
                $paramFetcher->get('limit'),
                $totalPages,
                'offset',
                'limit',
                true,
                $totalUsers
            );

        return $representationUsers;
    }

}