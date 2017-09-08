<?php

namespace AppBundle\Service\Representation;

use Doctrine\ORM\EntityRepository;
use Hateoas\Representation\PaginatedRepresentation;
use JMS\Serializer\Serializer;

class AbstractRepresentation
{
    protected $customRepository;
    protected $serializer;

    public function __construct(EntityRepository $customRepository, Serializer $serializer)
    {
        $this->customRepository = $customRepository;
        $this->serializer = $serializer;
    }

    protected function makeLayout(PaginatedRepresentation $representation, $type)
    {
        $json = $this->serializer->serialize($representation, 'json');
        $array = $this->serializer->deserialize($json, 'array', 'json');

        $formatted[$type] = $array['_embedded'][$type];
        $formatted['_links'] = $array['_links'];
        $formatted['_links']['info'] = [
            'page' => $array['page'],
            'limit' => $array['limit'],
            'pages' => $array['pages'],
            'total' => $array['total']
        ];

        return $formatted;
    }

}