<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     *     statusCode=201,
     *     serializerGroups={"create"}
     * )
     * @ParamConverter(
     *     "user",
     *     converter="fos_rest.request_body",
     *     options={
     *          "validator" = {"groups"="create"}
     *     }
     *)
     */
    public function createAction(User $user, ConstraintViolationList $violations, Request $request)
    {
        if (count($violations)) {
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }

        $user->setPassword($this->get('security.password_encoder')->encodePassword($user, $user->getPassword()));

        $client = $this
            ->get('app_bundle.client_manager')
            ->createClient($this->getParameter('redirect_uri'));

        $authCode = $this
            ->get('app_bundle.authorization_code_manager')
            ->getAuthorizationCode($client, $user, $request, $this->getParameter('redirect_uri'));

        $accessToken = $this
            ->get('app_bundle.access_token_manager')
            ->getTokenAccess($authCode, $request, $client, $this->getParameter('redirect_uri'));

        return [
            'data' => $user,
            '_links' => $this->generateUrl('user_show', ['id' => $user->getId()]),
            '_embedded' => $accessToken
        ];
    }
}