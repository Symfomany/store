<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderDetail
 *
 * @ORM\Table(name="order_detail")
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\OrderDetailRepository")
 */
class OrderDetail
{


    /**
     * @var \Order
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="detail")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    protected $order;

    /**
     * @var \Product
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    protected $product;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    protected $quantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="float", nullable=true)
     */
    protected $price;



    /**
     * Constructor
     */
    public function __construct(){
        $this->quantity = 1;
    }


    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return OrderDetail
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return OrderDetail
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
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
     * Set order
     *
     * @param \Store\BackendBundle\Entity\Order $order
     * @return OrderDetail
     */
    public function setOrder(\Store\BackendBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Store\BackendBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product
     *
     * @param \Store\BackendBundle\Entity\Product $product
     * @return OrderDetail
     */
    public function setProduct(\Store\BackendBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Store\BackendBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Get product
     *
     * @return \Store\BackendBundle\Entity\Product
     */
    public function getLine()
    {
        return $this->getQuantity() . " ". $this->getProduct()->getTitle(). " : " . $this->getPrice() ."€";
    }


}
