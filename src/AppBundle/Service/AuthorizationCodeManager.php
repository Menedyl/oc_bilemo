<?php

namespace AppBundle\Service;

use AppBundle\Entity\Client;
use OAuth2\OAuth2;
use Symfony\Component\HttpFoundation\Request;

class AuthorizationCodeManager
{
    private $Oauth2;


    public function __construct(OAuth2 $OAuth2)
    {
        $this->Oauth2 = $OAuth2;
    }

    public function getAuthorizationCode(Client $client, $data, Request $request, $redirectUri)
    {
        $request->query->add([
            'client_id' => $client->getPublicId(),
            'redirect_uri' => $redirectUri,
            'response_type' => 'code'

        ]);

        $response = $this->Oauth2->finishClientAuthorization(true, $data, $request);

        return substr($response->headers->get('location'), 48);
    }
}