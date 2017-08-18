<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $user1 = new User();
        $user1->setName('Nicolas');
        $user1->setPassword('test1');
        $user1->setMail('nicolas@gmail.com');

        $user2 = new User();
        $user2->setName('Mickael');
        $user2->setPassword('test2');
        $user2->setMail('mickael@gmail.com');

        $users = array($user1, $user2);

        foreach ($users as $user) {
            $manager->persist($user);
        }

        $manager->flush();

    }

    public function getOrder()
    {
        return 2;
    }

}