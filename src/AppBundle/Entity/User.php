<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *          "user_show",
 *          parameters = {"id" = "expr(object.getId())"},
 *          absolute=true
 *     )
 * )
 */
class User
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
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Serializer\Groups({"details", "list"})
     *
     * @Assert\NotBlank(
     *     groups={"create"}
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     *
     * @Serializer\Groups({"private"})
     *
     * @Assert\NotBlank(
     *     groups={"create"}
     * )
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     *
     * @Serializer\Groups({"details", "list"})
     *
     * @Assert\NotBlank(
     *     groups={"create"}
     * )
     * @Assert\Email(
     *     groups={"create"}
     * )
     */
    private $mail;


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
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set mail
     *
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }
}
