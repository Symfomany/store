<?php

namespace Store\BackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Store\BackendBundle\Validator\Constraints as StoreAssert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Cms
 *
 * @ORM\Table(name="cms", indexes={@ORM\Index(name="jeweler_id", columns={"jeweler_id"})})
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\CmsRepository")
 * @UniqueEntity(fields="title", message="Votre titre de bijoux est déjà existant", groups={"new"})
 * @ORM\HasLifecycleCallbacks()
 */
class Cms
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
     *     message = "cms.form.validation.title.notblank",
     *     groups={"new", "edit"}
     * )
     * @Assert\Length(
     *      min = "4",
     *      max = "300",
     *      minMessage = "cms.form.validation.title.length.min",
     *      maxMessage = "cms.form.validation.title.length.max",
     *      groups={"new", "edit"}
     * )     * @ORM\Column(name="title", type="string", length=300, nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "La résumé ne doit pas etre vide",
     *     groups={"new", "edit"}
     * )
     * @StoreAssert\StripTagLength(groups={"new", "edit"})
     * @ORM\Column(name="summary", type="text", nullable=true)
     */
    protected $summary;

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
     * @var string
     * @Assert\Regex(pattern="/(<iframe.*?>.*?<\/iframe>)/",
     *                          message="La vidéo n'est pas valide",
     *                          groups={"new", "edit"}
     * )
     * @ORM\Column(name="video", type="string", length=300, nullable=true)
     */
    protected $video;

    /**
     * @var integer
     * @Assert\Choice(choices = {"0","1","2"},
     *                message = "Choisissez un état valide",
     *                groups={"new", "edit"}
     * )
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    protected $state;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    protected $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_active", type="datetime", nullable=true)
     */
    protected $dateActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=true)
     */
    protected $dateUpdated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    protected $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="view", type="integer", nullable=true)
     */
    protected $view;

    /**
     * @var \Jeweler
     *
     * @ORM\ManyToOne(targetEntity="Jeweler")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="jeweler_id", referencedColumnName="id")
     * })
     */
    protected $jeweler;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="cms")
     */
    protected $product;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreated = new \DateTime('now');
        $this->dateUpdated = new \DateTime('now');
        $this->dateActive = new \DateTime('now');
        $this->view = 0;
        $this->active = 1;
        $this->state = 1;
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Cms
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
     * @return Cms
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
     * @return Cms
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
     * Set image
     *
     * @param string $image
     * @return Cms
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
     * Set video
     *
     * @param string $video
     * @return Cms
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return Cms
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Cms
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
     * @return Cms
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
     * Set dateUpdated
     * @ORM\PreUpdate
     * @param \DateTime $dateUpdated
     * @return Product
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = new \DateTime('now');

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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Cms
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
     * Set jeweler
     *
     * @param \Store\BackendBundle\Entity\Jeweler $jeweler
     * @return Cms
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

//    /**
//     * Add product
//     *
//     * @param \Store\BackendBundle\Entity\Product $product
//     * @return Cms
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
     * Override to control all product
     * @param ArrayCollection $products
     */
    public function setProduct(ArrayCollection $products)
    {
        foreach ($products as $product) {
            $product->addCms($this);
        }

        $this->product = $products;
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
     * Set view
     *
     * @param integer $view
     * @return Cms
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return integer 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Retourne le titre
     */
    public function __toString(){
        return $this->title;
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
        return 'uploads/cms';
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
