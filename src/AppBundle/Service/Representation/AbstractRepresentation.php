<?php

namespace AppBundle\Service\Representation;

use Doctrine\ORM\EntityRepository;
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
}
