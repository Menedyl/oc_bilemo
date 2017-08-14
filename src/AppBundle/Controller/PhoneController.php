<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Phone;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
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
     *     serializerGroups={"detail"}
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
     *     serializerGroups={"list"}
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

        $currentPhones = count($phones);
        $totalPhones = count($this->getDoctrine()->getRepository('AppBundle:Phone')->findAll());
        $totalPages = ceil($totalPhones / $paramFetcher->get('limit'));

        $pagerPhones = [
            'data' => $phones,
            'meta' => [
                'limit_items' => (int)$paramFetcher->get('limit'),
                'current_items' => $currentPhones,
                'total_items' => $totalPhones,
                'current_page' => (int)$paramFetcher->get('offset'),
                'total_pages' => $totalPages
            ]];

        return $pagerPhones;
    }
}
