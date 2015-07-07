<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tag.
 *
 * @ORM\Table(name="tag")
 * @UniqueEntity(fields="word", message="Votre mots-clef est déjà existant")
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\TagRepository")
 */
class Tag
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
     * @Assert\NotBlank(
     *     message = "Le mots-clef ne doit pas etre vide",
     * )
     * @Assert\Regex(
     *     message = "Le mots-clef doit être valide (caractères alphanumérique au minimum de 4)",
     *     pattern="/^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]{4,70}/"
     * ))
     * @ORM\Column(name="word", type="string", length=100, nullable=true)
     */
    protected $word;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="tag")
     */
    protected $product;

    /**
     * Constructor.
     */
    public function __construct()
    {
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
     * Set word.
     *
     * @param string $word
     *
     * @return Tag
     */
    public function setWord($word)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word.
     *
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Add product.
     *
     * @param \Store\BackendBundle\Entity\Product $product
     *
     * @return Tag
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
     * Retourne le mot clefs.
     */
    public function __toString()
    {
        return $this->word;
    }
}
