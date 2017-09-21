<?php

namespace AppBundle\Service\Representation;


use FOS\RestBundle\Request\ParamFetcherInterface;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;

class Users extends AbstractRepresentation
{
    const TYPE = 'users';


    public function paginate($users, ParamFetcherInterface $paramFetcher)
    {
        $totalUsers = count($this->customRepository->findAll());
        $totalPages = ceil($totalUsers / $paramFetcher->get('limit'));

        $representationUsers =
            new PaginatedRepresentation(
                new CollectionRepresentation(
                    $users,
                    self::TYPE
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
