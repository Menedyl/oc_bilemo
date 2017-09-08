<?php

namespace AppBundle\Service\Representation;

use FOS\RestBundle\Request\ParamFetcherInterface;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;

class Phones extends AbstractRepresentation
{
    const TYPE = 'phones';

    public function pagination($phones, ParamFetcherInterface $paramFetcher)
    {
        $totalPhones = count($this->customRepository->findAll());
        $totalPages = ceil($totalPhones / $paramFetcher->get('limit'));

        $representationPhones =
            new PaginatedRepresentation(
                new CollectionRepresentation(
                    $phones,
                    self::TYPE
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

        return $this->makeLayout($representationPhones, self::TYPE);
    }

}