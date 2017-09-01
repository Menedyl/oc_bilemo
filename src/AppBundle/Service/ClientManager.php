<?php

namespace AppBundle\Service;

use FOS\OAuthServerBundle\Model\ClientManagerInterface;

class ClientManager
{
    private $clientManager;


    public function __construct(ClientManagerInterface $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    public function createClient($redirectUri)
    {
        $client = $this->clientManager->createClient();

        $client->setRedirectUris([$redirectUri]);
        $client->setAllowedGrantTypes(['token', 'authorization_code']);

        $this->clientManager->updateClient($client);

        return $client;
    }
}