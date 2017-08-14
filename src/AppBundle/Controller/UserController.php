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
     *     serializerGroups={"detail"}
     * )
     */
    public function showAction(User $user)
    {
        return $user;
    }


    /**
     * @Rest\Get(
     *     path="/users",
     *     name="user_list"
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
     *     serializerGroups={"list"}
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

        $currentUsers = count($users);
        $totalUsers = count($this->getDoctrine()->getRepository('AppBundle:User')->findAll());
        $totalPages = ceil($totalUsers / $paramFetcher->get('limit'));

        $pagerUsers = [
            'data' => $users,
            'meta' => [
                'limit_items' => (int)$paramFetcher->get('limit'),
                'current_items' => $currentUsers,
                'total_items' => $totalUsers,
                'current_page' => (int)$paramFetcher->get('offset'),
                'total_pages' => $totalPages
            ]];

        return $pagerUsers;
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
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
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