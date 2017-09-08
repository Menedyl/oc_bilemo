<?php

namespace AppBundle\Service\Representation;


use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;

class Phones
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function pagination($phones, ParamFetcherInterface $paramFetcher)
    {
        $totalPhones = count($this->em->getRepository('AppBundle:Phone')->findAll());
        $totalPages = ceil($totalPhones / $paramFetcher->get('limit'));

        $representationPhones =
            new PaginatedRepresentation(
                new CollectionRepresentation(
                    $phones,
                    'phones'
                ),
                'phones_list',
                [],
                $paramFetcher->get('offset'),
                $paramFetcher->get('limit'),
                $totalPages,
                'offset',
                'limit',
                true,
                $totalPhones
            );

        return $representationPhones;
    }

}