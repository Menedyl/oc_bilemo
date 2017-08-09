<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Phone;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PhoneController extends Controller
{

    /**
     * @Rest\Get(
     *     path="/phones/{id}",
     *     name="phone_show",
     *     requirements={"id" = "\d+"}
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"show"}
     * )
     */
    public function showAction(Phone $phone)
    {
        return $phone;
    }

}
