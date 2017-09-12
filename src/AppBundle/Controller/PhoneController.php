<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Phone;
use AppBundle\Service\Representation\Phones;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PhoneController extends Controller
{

    /**
     * @Rest\Get(
     *     path="/phones/{id}",
     *     name="phone_show",
     *     requirements={"id" = "\d+"},
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"details", "Default"}
     * )
     * @ApiDoc(
     *     resource=true,
     *     description="Get one phone",
     *     section="Phones",
     *     statusCodes={
     *          200="Returned when find phone",
     *          404="Returned when not found phone"
     *      },
     *     requirements={
     *         {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The phone unique identifier."
     *          }
     *     }
     * )
     */
    public function showAction(Phone $phone)
    {
        return $phone;
    }


    /**
     * @Rest\Get(
     *     path="/phones",
     *     name="phones_list"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="20",
     *     description="Max number of phones per page."
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
     *     description="Get the list of all phones",
     *     section="Phones",
     *     statusCodes={
     *          200="Returned when find list of all phones"
     *      }
     * )
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $phones = $this->getDoctrine()->getRepository('AppBundle:Phone')->getList(
            $paramFetcher->get('limit'),
            $paramFetcher->get('order'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('keyword')
        );

        return $this->get(Phones::class)->pagination($phones, $paramFetcher);
    }
}
