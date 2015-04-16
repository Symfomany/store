<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Product
 * @ORM\Table(name="product", indexes={@ORM\Index(name="jeweler_id", columns={"jeweler_id"})})
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\ProductRepository")
 * @UniqueEntity(fields="ref", message="Votre référence de bijoux est déjà existant")
 * @UniqueEntity(fields="title", message="Votre titre de bijoux est déjà existant")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\Regex(pattern="/[A-Z]{4}-[0-9]{2}-[A-Z]{1}/",
 *                              message="La référence n'est pas valide")
     * @Assert\NotBlank(
     *     message = "La référence ne doit pas etre vide"
     * )
     * @ORM\Column(name="ref", type="string", length=30, nullable=true)
     */
    private $ref;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "La titre ne doit pas etre vide"
     * )
     * @Assert\Length(
     *      min = "4",
     *      max = "300",
     *      minMessage = "Votre titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre titre ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="title", type="string", length=150, nullable=true)
     */
    private $title;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "La résumé ne doit pas etre vide"
     * )
     * @Assert\Length(
     *      min = "10",
     *      max = "500",
     *      minMessage = "Votre résumé doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre résumé ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="summary", type="text", nullable=true)
     */
    private $summary;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "La description ne doit pas etre vide"
     * )
     * @Assert\Length(
     *      min = "15",
     *      max = "500",
     *      minMessage = "La description doit faire au moins {{ limit }} caractères",
     *      maxMessage = "La description ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "La composition ne doit pas etre vide"
     * )
     * @Assert\Length(
     *      min = "5",
     *      max = "500",
     *      minMessage = "La composition doit faire au moins {{ limit }} caractères",
     *      maxMessage = "La composition ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="composition", type="text", nullable=true)
     */
    private $composition;

    /**
     * @Assert\NotBlank(
     *     message = "Le prix ne doit pas etre vide"
     * )
     * @Assert\Range(
     *      min = 10,
     *      max = 5000,
     *      minMessage = "Votre bijoux doit avoir la valeur maximum de {{ limit }} €",
     *      maxMessage = "Votre bijoux doit avoir la valeur maximum de {{ limit }} €",
     * )
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @Assert\Choice(choices = {"5.5", "19.6", "20"},
     *                          message = "Choisissez une taxe valide")
     * @ORM\Column(name="taxe", type="float", nullable=true)
     */
    private $taxe;

    /**
     * @Assert\NotBlank(
     *     message = "Le prix ne doit pas etre vide"
     * )
     * @Assert\Range(
     *      min = 1,
     *      max = 200,
     *      minMessage = "Votre bijoux doit avoir la quantité minimum de {{ limit }} €",
     *      maxMessage = "Votre bijoux doit avoir la quantité maximum de {{ limit }} €",
     * )
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_active", type="datetime", nullable=true)
     */
    private $dateActive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cover", type="boolean", nullable=true)
     */
    private $cover;

    /**
     * @var boolean
     *
     * @ORM\Column(name="shop", type="boolean", nullable=true)
     */
    private $shop;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=300, nullable=true)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=true)
     */
    private $dateUpdated;

    /**
     * @var \Jeweler
     *
     * @ORM\ManyToOne(targetEntity="Jeweler")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="jeweler_id", referencedColumnName="id")
     * })
     */
    private $jeweler;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Business", inversedBy="product")
     * @ORM\JoinTable(name="product_business",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="business_id", referencedColumnName="id")
     *   }
     * )
     */
    private $business;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @Assert\Count(
     *      min = "1",
     *      max = "10",
     *      minMessage = "Vous devez spécifier au moins une catégorie",
     *      maxMessage = "Vous ne pouvez pas spécifier plus de {{ limit }} catégorie"
     * )
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="product")
     * @ORM\JoinTable(name="product_category",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *   }
     * )
     */
    private $category;

    /**
     * @Assert\Count(
     *      min = "1",
     *      max = "10",
     *      minMessage = "Vous devez spécifier au moins une catégorie",
     *      maxMessage = "Vous ne pouvez pas spécifier plus de {{ limit }} catégorie"
     * )
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Cms", inversedBy="product")
     * @ORM\JoinTable(name="product_cms",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="cms_id", referencedColumnName="id")
     *   }
     * )
     */
    private $cms;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Supplier", inversedBy="product")
     * @ORM\JoinTable(name="product_supplier",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     *   }
     * )
     */
    private $supplier;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="product")
     * @ORM\JoinTable(name="product_tag",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *   }
     * )
     */
    private $tag;


    /**
     * @var boolean
     * @ORM\OneToOne(targetEntity="ProductMeta", mappedBy="product")
     **/
    private $meta;


    /**
     * Constructeur qui initialise les propriété de mon objet Product
     * Initialisation de mes attributs de mon objet
     */
    public function __construct()
    {
        $this->active = true;
        $this->cover = false;
        $this->dateActive = new \DateTime('now');
        $this->taxe = 20;
        $this->shop = true;
        $this->quantity = 1;
        $this->price = 0;


        $this->dateCreated = new \DateTime('now');
        $this->dateUpdated = new \DateTime('now');
        $this->business = new \Doctrine\Common\Collections\ArrayCollection();
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cms = new \Doctrine\Common\Collections\ArrayCollection();
        $this->supplier = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return Product
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return Product
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * Set composition
     *
     * @param string $composition
     * @return Product
     */
    public function setComposition($composition)
    {
        $this->composition = $composition;

        return $this;
    }

    /**
     * Get composition
     *
     * @return string 
     */
    public function getComposition()
    {
        return $this->composition;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
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
     * Set taxe
     *
     * @param integer $taxe
     * @return Product
     */
    public function setTaxe($taxe)
    {
        $this->taxe = $taxe;

        return $this;
    }

    /**
     * Get taxe
     *
     * @return integer 
     */
    public function getTaxe()
    {
        return $this->taxe;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Product
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
     * Set active
     *
     * @param boolean $active
     * @return Product
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set dateActive
     *
     * @param \DateTime $dateActive
     * @return Product
     */
    public function setDateActive($dateActive)
    {
        $this->dateActive = $dateActive;

        return $this;
    }

    /**
     * Get dateActive
     *
     * @return \DateTime 
     */
    public function getDateActive()
    {
        return $this->dateActive;
    }

    /**
     * Set cover
     *
     * @param boolean $cover
     * @return Product
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return boolean 
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set shop
     *
     * @param boolean $shop
     * @return Product
     */
    public function setShop($shop)
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * Get shop
     *
     * @return boolean 
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Product
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Product
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     * @return Product
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set jeweler
     *
     * @param \Store\BackendBundle\Entity\Jeweler $jeweler
     * @return Product
     */
    public function setJeweler(\Store\BackendBundle\Entity\Jeweler $jeweler = null)
    {
        $this->jeweler = $jeweler;

        return $this;
    }

    /**
     * Get jeweler
     *
     * @return \Store\BackendBundle\Entity\Jeweler 
     */
    public function getJeweler()
    {
        return $this->jeweler;
    }

    /**
     * Add business
     *
     * @param \Store\BackendBundle\Entity\Product $business
     * @return Product
     */
    public function addBusiness(\Store\BackendBundle\Entity\Product $business)
    {
        $this->business[] = $business;

        return $this;
    }

    /**
     * Remove business
     *
     * @param \Store\BackendBundle\Entity\Product $business
     */
    public function removeBusiness(\Store\BackendBundle\Entity\Product $business)
    {
        $this->business->removeElement($business);
    }

    /**
     * Get business
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * Add category
     *
     * @param \Store\BackendBundle\Entity\Category $category
     * @return Product
     */
    public function addCategory(\Store\BackendBundle\Entity\Category $category)
    {
        $this->category[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Store\BackendBundle\Entity\Category $category
     */
    public function removeCategory(\Store\BackendBundle\Entity\Category $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add cms
     *
     * @param \Store\BackendBundle\Entity\Cms $cms
     * @return Product
     */
    public function addCm(\Store\BackendBundle\Entity\Cms $cms)
    {
        $this->cms[] = $cms;

        return $this;
    }

    /**
     * Remove cms
     *
     * @param \Store\BackendBundle\Entity\Cms $cms
     */
    public function removeCm(\Store\BackendBundle\Entity\Cms $cms)
    {
        $this->cms->removeElement($cms);
    }

    /**
     * Get cms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCms()
    {
        return $this->cms;
    }

    /**
     * Add supplier
     *
     * @param \Store\BackendBundle\Entity\Supplier $supplier
     * @return Product
     */
    public function addSupplier(\Store\BackendBundle\Entity\Supplier $supplier)
    {
        $this->supplier[] = $supplier;

        return $this;
    }

    /**
     * Remove supplier
     *
     * @param \Store\BackendBundle\Entity\Supplier $supplier
     */
    public function removeSupplier(\Store\BackendBundle\Entity\Supplier $supplier)
    {
        $this->supplier->removeElement($supplier);
    }

    /**
     * Get supplier
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Add tag
     *
     * @param \Store\BackendBundle\Entity\Tag $tag
     * @return Product
     */
    public function addTag(\Store\BackendBundle\Entity\Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Store\BackendBundle\Entity\Tag $tag
     */
    public function removeTag(\Store\BackendBundle\Entity\Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set meta
     *
     * @param \Store\BackendBundle\Entity\ProductMeta $meta
     * @return Product
     */
    public function setMeta(\Store\BackendBundle\Entity\ProductMeta $meta = null)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Get meta
     *
     * @return \Store\BackendBundle\Entity\ProductMeta 
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Retourne le title
     */
    public function __toString(){
        return $this->title;
    }
}
