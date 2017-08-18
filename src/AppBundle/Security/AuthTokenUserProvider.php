<?php

namespace AppBundle\Security;


use AppBundle\Repository\AuthTokenRepository;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthTokenUserProvider implements UserProviderInterface
{
    /** @var AuthTokenRepository  */
    private $authTokenRepository;

    /** @var UserRepository  */
    private $userRepository;

    public function __construct(EntityRepository $authTokenRepository, EntityRepository $userRepository)
    {
        $this->authTokenRepository = $authTokenRepository;
        $this->userRepository = $userRepository;
    }

    public function getAuthToken($authTokenHeader){

        return $this->authTokenRepository->findOneByValue($authTokenHeader);
    }

    public function loadUserByUsername($username)
    {
        return $this->userRepository->findOneByMail($username);
    }

    public function supportsClass($class)
    {
        return 'AppBundle\Entity\User' === $class;
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

}