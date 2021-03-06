<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductImage.
 *
 * @ORM\Table(name="product_image", indexes={@ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\ProductImageRepository")
 */
class ProductImage
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
     * @ORM\Column(name="image", type="string", length=300, nullable=true)
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\Column(name="image_thumb", type="string", length=300, nullable=true)
     */
    protected $imageThumb;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    protected $product;

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
     * Set image.
     *
     * @param string $image
     *
     * @return ProductImage
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set imageThumb.
     *
     * @param string $imageThumb
     *
     * @return ProductImage
     */
    public function setImageThumb($imageThumb)
    {
        $this->imageThumb = $imageThumb;

        return $this;
    }

    /**
     * Get imageThumb.
     *
     * @return string
     */
    public function getImageThumb()
    {
        return $this->imageThumb;
    }

    /**
     * Set product.
     *
     * @param \Store\BackendBundle\Entity\Product $product
     *
     * @return ProductImage
     */
    public function setProduct(\Store\BackendBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return \Store\BackendBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Retourne le title.
     */
    public function __toString()
    {
        return $this->image;
    }
}
