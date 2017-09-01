<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Phone;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPhoneData extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $phone1 = new Phone();
        $phone1->setName('Galaxy S8');
        $phone1->setDescription('Samsumg Galaxy S8 Noir carbone, une phablette puissante et performante, idéale pour les utilisateurs intensifs.');
        $phone1->setPrice(139.9);
        $phone1->setPictureUrl('http://cdn.androidicecreamsandwich.de/wp-content/uploads/2017/03/samsung-galaxy-s8.jpg');


        $phone2 = new Phone();
        $phone2->setName('Apple iPhone 7');
        $phone2->setDescription('Apple iPhone 7 Noir, un flagship 4G+ haut de gamme très performant.');
        $phone2->setPrice(189.9);
        $phone2->setPictureUrl('http://cdn2.gsmarena.com/vv/pics/apple/apple-iphone-7-2.jpg');


        $phone3 = new Phone();
        $phone3->setName('Huawei P10');
        $phone3->setDescription('Huawei P10 Noir, un flagship conçu pour faire des portraits de qualité.');
        $phone3->setPrice(573.9);
        $phone3->setPictureUrl('http://hwnpf26968.i.lithium.com/t5/image/serverpage/image-id/1499i8247A598894B1D0B/image-size/large?v=1.0&px=600');


        $phone4 = new Phone();
        $phone4->setName('Sony Xperia XZ');
        $phone4->setDescription('Sony Xperia XZ Noir, un smartphone Android puissant frôlant la perfection !');
        $phone4->setPrice(129.9);
        $phone4->setPictureUrl('https://www.android4ar.com/wp-content/uploads/2016/09/Sony-Xperia-XZ.jpg');

        $phones = array($phone1, $phone2, $phone3, $phone4);

        foreach ($phones as $phone) {
            $manager->persist($phone);
        }

        $manager->flush();

    }

    public function getOrder()
    {
        return 1;
    }

}