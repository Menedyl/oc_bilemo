<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    /**
     * @Rest\Get(
     *     path="/users/{id}",
     *     name="user_show",
     *     requirements={"id" = "\d+"}
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"show"}
     * )
     */
    public function showAction(User $user)
    {
        return $user;
    }

}