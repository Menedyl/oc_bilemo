<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity()
 */
class Client extends BaseClient
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     *
     * @Serializer\Groups("details")
     */
    protected $id;

    /**
     * @Serializer\Groups("details")
     */
    protected $allowedGrantTypes;

    /**
     * @Serializer\Groups("details")
     */
    protected $redirectUris;


    public function __construct()
    {
        parent::__construct();
    }

    public function getPublicId()
    {
        return parent::getPublicId();
    }

}
