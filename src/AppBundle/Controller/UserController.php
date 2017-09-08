<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class UserController extends FOSRestController
{

    /**
     * @Rest\Get(
     *     path="/users/{id}",
     *     name="user_show",
     *     requirements={"id" = "\d+"}
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"details", "Default"}
     * )
     */
    public function showAction(User $user)
    {
        return $user;
    }


    /**
     * @Rest\Get(
     *     path="/users",
     *     name="users_list"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="20",
     *     description="Max number of users per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="1",
     *     description="The pagination offset."
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)."
     * )
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="\w+",
     *     nullable=true,
     *     description="Search query to look for users."
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"list", "Default"}
     * )
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->getList(
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('order'),
            $paramFetcher->get('keyword')
        );

        return $this->get('AppBundle\Service\Representation\Users')->paginate($users, $paramFetcher);
    }


    /**
     * @Rest\Post(
     *     path="/users",
     *     name="user_create"
     * )
     * @Rest\View(
     *     statusCode=201
     * )
     * @ParamConverter(
     *     "user",
     *     converter="fos_rest.request_body",
     *     options={
     *          "validator" = {"groups"="create"}
     *     }
     *)
     */
    public function createAction(User $user, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $this->get('AppBundle\Service\ExceptionManagement')->resourceValidation($violations);
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        return $this->view($user, Response::HTTP_CREATED,
            ['Location' => $this->generateUrl(
                'user_show',
                ['id' => $user->getId(),
                    UrlGeneratorInterface::ABSOLUTE_URL])]);

    }
}