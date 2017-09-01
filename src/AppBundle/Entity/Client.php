<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;

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
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }

}