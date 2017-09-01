<?php

namespace AppBundle\Security;


use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $em;


    public function __construct(EntityManager $entityManager, Serializer $serializer)
    {
        $this->em = $entityManager;
        $this->serializer = $serializer;
    }

    public function loadUserByUsername($username)
    {

        $user = $this->em->getRepository("AppBundle:User")->findOneBy(['mail' => $username]);

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