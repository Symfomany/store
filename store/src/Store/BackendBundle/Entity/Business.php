<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Business.
 *
 * @ORM\Table(name="business")
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\BusinessRepository")
 */
class Business
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
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    protected $type;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=true)
     */
    protected $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=300, nullable=true)
     */
    protected $message;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    protected $active;

    /**
     * @var \DateTime
     */
    protected $dateExpired;

    /**
     * @var \DateTime
     */
    protected $dateCreated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="business")
     */
    protected $product;

    /**
     * Initialize my object.
     */
    public function __construct()
    {
        $this->dateExpired = new \DateTime('now');
        $this->dateCreated = new \DateTime('now');
        $this->type = 1;
        $this->active = 1;
        $this->amount = 0;
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set type.
     *
     * @param int $type
     *
     * @return Business
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

    /**
     * Set amount.
     *
     * @param float $amount
     *
     * @return Business
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set message.
     *
     * @param string $message
     *
     * @return Business
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set dateExpired.
     *
     * @param \DateTime $dateExpired
     *
     * @return Business
     */
    public function setDateExpired($dateExpired)
    {
        $this->dateExpired = $dateExpired;

        return $this;
    }

    /**
     * Get dateExpired.
     *
     * @return \DateTime
     */
    public function getDateExpired()
    {
        return $this->dateExpired;
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return Business
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set dateCreated.
     *
     * @param \DateTime $dateCreated
     *
     * @return Business
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated.
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Add product.
     *
     * @param \Store\BackendBundle\Entity\Product $product
     *
     * @return Business
     */
    public function addProduct(\Store\BackendBundle\Entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product.
     *
     * @param \Store\BackendBundle\Entity\Product $product
     */
    public function removeProduct(\Store\BackendBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Retourne le montant.
     *
     * @return float|int
     */
    public function __toString()
    {
        return $this->amount;
    }
}
