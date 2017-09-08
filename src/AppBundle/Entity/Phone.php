<?php

namespace AppBundle\Entity;

use Hateoas\Configuration\Annotation as Hateoas;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Phone
 *
 * @ORM\Table(name="phone")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhoneRepository")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *          "phone_show",
 *          parameters = {"id" = "expr(object.getId())"},
 *          absolute=true
 *     )
 * )
 */
class Phone
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"details"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @Serializer\Groups({"details", "list"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Serializer\Groups({"details"})
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     *
     * @Serializer\Groups({"details", "list"})
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="picture_url", type="string", length=255)
     *
     * @Serializer\Groups({"details"})
     */
    private $pictureUrl;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get pictureUrl
     *
     * @return string
     */
    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    /**
     * Set pictureUrl
     *
     * @param string $pictureUrl
     */
    public function setPictureUrl($pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;
    }
}
