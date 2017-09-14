<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Service\ClientManager;
use AppBundle\Service\ExceptionManagement;
use AppBundle\Service\Representation\Users;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @ApiDoc(
     *     resource=true,
     *     description="Get one user",
     *     section="Users",
     *     statusCodes={
     *          200="Returned when find user",
     *          404="Returned when not found user"
     *      },
     *     requirements={
     *         {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The user unique identifier."
     *          }
     *     }
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
     * @ApiDoc(
     *     resource=true,
     *     description="Get the list of all users",
     *     section="Users",
     *     statusCodes={
     *          200="Returned when find list of all users",
     *      }
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

        return $this->get(Users::class)->paginate($users, $paramFetcher);
    }


    /**
     * @Rest\Post(
     *     path="/users",
     *     name="user_create"
     * )
     * @Rest\View(
     *     statusCode=201,
     *     serializerGroups={"create", "Default"}
     * )
     * @ParamConverter(
     *     "user",
     *     converter="fos_rest.request_body",
     *     options={
     *          "validator" = {"groups"="create"}
     *     }
     *)
     * @ApiDoc(
     *     resource=true,
     *     description="create one user",
     *     section="Users",
     *     statusCodes={
     *          201="Returned when create user",
     *          400="Returned when a field is invalid",
     *          409="Returned when unique constraint violation"
     *
     *      },
     *     requirements={
     *         {
     *              "name"="name",
     *              "dataType"="string",
     *              "description"="The name of user."
     *          },
     *          {
     *              "name"="password",
     *              "dataType"="string",
     *              "description"="The password of user."
     *          },
     *         {
     *              "name"="mail",
     *              "dataType"="string",
     *              "description"="The mail of user."
     *          }
     *     }
     * )
     */
    public function createAction(User $user, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $this->get(ExceptionManagement::class)->resourceValidationException($violations);
        }

        $user->setPassword($this->get('security.password_encoder')->encodePassword($user, $user->getPassword()));

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $client = $this->get(ClientManager::class)->createClient($this->getParameter('redirect_uri'));

        return [
            'user' => $user,
            '_embedded' => [
                'client' => [
                    'client_id' => $client->getPublicId(),
                    'client_secret' => $client->getSecret()
                ]
            ]
        ];
    }
}