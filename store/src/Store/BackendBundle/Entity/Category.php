<?php

namespace Store\BackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "La titre ne doit pas etre vide",
     *     groups={"new", "edit"}
     * )
     * @Assert\Length(
     *      min = "4",
     *      max = "300",
     *      minMessage = "Votre titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre titre ne peut pas être plus long que {{ limit }} caractères",
     *      groups={"new", "edit"}
     * )
     * @ORM\Column(name="title", type="string", length=300, nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "La description ne doit pas etre vide",
     *     groups={"new", "edit"}
     * )
     * @Assert\Length(
     *      min = "15",
     *      max = "5000",
     *      minMessage = "La description doit faire au moins {{ limit }} caractères",
     *      maxMessage = "La description ne peut pas être plus long que {{ limit }} caractères",
     *      groups={"new", "edit"}
     * )
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    protected $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    protected $active;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "Vous devez au moins associé au moins un bijou",
     *      groups={"new", "edit"}
     * )
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="category", cascade={"all"})
     */
    protected $product;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Jeweler")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="jeweler_id", referencedColumnName="id")
     * })
     */
    protected $jeweler;

    /**
     * @ORM\Column(name="image", type="string", nullable=true)
     */
    protected $image;


    /**
     * Attribut qui représentera mon fichier uploadé
     * @Assert\Image(
     *     minWidth = 100,
     *     maxWidth = 3000,
     *     minHeight = 100,
     *     maxHeight = 2500,
     *     maxWidthMessage= "La largeur est trop grande",
     *     minWidthMessage = "La largeur est trop petite",
     *     maxHeightMessage = "La hauteur est trop grande",
     *     minHeightMessage = "La largeur est trop petite",
     *     groups={"new", "edit"}
     * )
     */
    protected $file;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->active = true;
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
     * Set title
     *
     * @param string $title
     * @return Category
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
     * Set description
     *
     * @param string $description
     * @return Category
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
     * Set position
     *
     * @param integer $position
     * @return Category
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
     * Set active
     *
     * @param boolean $active
     * @return Category
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
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Override to control all product
     * @param ArrayCollection $products
     */
    public function setProduct(ArrayCollection $products)
    {
        foreach ($products as $product) {
            $product->addCategory($this);
        }

        $this->product = $products;
    }


//    /**
//     * Add product
//     *
//     * @param \Store\BackendBundle\Entity\Product $product
//     * @return Category
//     */
//    public function addProduct(\Store\BackendBundle\Entity\Product $product)
//    {
//        $this->product[] = $product;
//
//        return $this;
//    }
//
//    /**
//     * Remove product
//     *
//     * @param \Store\BackendBundle\Entity\Product $product
//     */
//    public function removeProduct(\Store\BackendBundle\Entity\Product $product)
//    {
//        $this->product->removeElement($product);
//    }


    /**
     * Set jeweler
     *
     * @param \Store\BackendBundle\Entity\Jeweler $jeweler
     * @return Category
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
     * Retourne le titre
     */
    public function __toString(){
        return $this->title;
    }


    /**
     * @var \DateTime
     */
    protected $dateCreated;


    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Category
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
     * Set image
     *
     * @param string $image
     * @return Category
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * Retourne le chemin absolue de mon image
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir().'/'.$this->image;
    }


    /**
     * Retourne le chemin de l'image depuis le dossier web
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->image ? null : $this->getUploadDir().'/'.$this->image;
    }

    /**
     * Retourne le cheùin de mon image depuis l'entité
     * @return string
     */
    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Retourne le dossier d'upload et sous dossier product
     * @return string
     */
    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/category';
    }


    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Mecanisme d'upload
     * + déplacement du fichier uploadé dans le bon dossier
     */
    public function upload()
    {
        // la propriété « file » peut être vide si le champ n'est pas requis
        if (null === $this->file) {
            return;
        }

        // utilisez le nom de fichier original ici mais
        // vous devriez « l'assainir » pour au moins éviter
        // quelconques problèmes de sécurité

        // Déplacer le fichier uploadé dans le bon répertoir
        // uploads/product/
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        // je stocke le nom du fichier uploadé dans mon
        //attribut image
        $this->image = $this->file->getClientOriginalName();

        // « nettoie » la propriété « file » comme vous n'en aurez plus besoin
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            @unlink($file);
        }
    }

}
