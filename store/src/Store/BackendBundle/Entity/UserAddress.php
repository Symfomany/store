<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAddress.
 *
 * @ORM\Table(name="user_address", indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\UserAddressRepository")
 */
class UserAddress
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=300, nullable=true)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="integer",  nullable=true)
     */
    protected $type;

    /**
     * @var int
     *
     * @ORM\Column(name="zipcode", type="integer", nullable=true)
     */
    protected $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    protected $address;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="address")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    protected $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->type = 1;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set city.
     *
     * @param string $city
     *
     * @return UserAddress
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zipcode.
     *
     * @param int $zipcode
     *
     * @return UserAddress
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode.
     *
     * @return int
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set address.
     *
     * @param string $address
     *
     * @return UserAddress
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set user.
     *
     * @param \Store\BackendBundle\Entity\User $user
     *
     * @return UserAddress
     */
    public function setUser(\Store\BackendBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Store\BackendBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Retourne le title.
     */
    public function __toString()
    {
        return $this->zipcode.' '.$this->address;
    }

    /**
     * Set type.
     *
     * @param int $type
     *
     * @return UserAddress
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }
}
