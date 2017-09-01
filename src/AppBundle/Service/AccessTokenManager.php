<?php

namespace AppBundle\Service;

use JMS\Serializer\Serializer;
use OAuth2\OAuth2;
use Symfony\Component\HttpFoundation\Request;

class AccessTokenManager
{
    private $OAuth2;
    private $serializer;


    public function __construct(OAuth2 $OAuth2, Serializer $serializer)
    {
        $this->OAuth2 = $OAuth2;
        $this->serializer = $serializer;
    }

    public function getTokenAccess($authCode, Request $request, $client, $redirectUri)
    {
        $request->request->add([
            'grant_type' => 'authorization_code',
            'code' => $authCode,
            'client_id' => $client->getPublicId(),
            'client_secret' => $client->getSecret(),
            'redirect_uri' => $redirectUri
        ]);

        $response = $this->OAuth2->grantAccessToken($request);

        return $this->serializer->deserialize($response->getContent(), 'array', 'json');
    }
}