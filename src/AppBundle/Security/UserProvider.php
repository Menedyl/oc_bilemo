<?php

namespace AppBundle\Security;


use Doctrine\ORM\EntityRepository;
use JMS\Serializer\Serializer;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $userRepo;


    public function __construct(EntityRepository $userRepo, Serializer $serializer)
    {
        $this->userRepo = $userRepo;
        $this->serializer = $serializer;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->userRepo->findOneBy(['mail' => $username]);

        if (!$user) {
            throw new \LogicException('Did not managed to get your user.');
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);

        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException();
        }

        return $user;
    }

    public function supportsClass($class)
    {
        return 'AppBundle\Entity\User' === $class;
    }

}
