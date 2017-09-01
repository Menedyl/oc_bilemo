<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
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
     *     serializerGroups={"details"}
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
            $paramFetcher->get('order')
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
}