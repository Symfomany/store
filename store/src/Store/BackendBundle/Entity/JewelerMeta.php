<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Store\BackendBundle\Validator\Constraints as StoreAssert;

/**
 * JewelerMeta
 *
 * @ORM\Table(name="jeweler_meta", indexes={@ORM\Index(name="jeweler_id", columns={"jeweler_id"})})
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\JewelerMetaRepository")
 */
class JewelerMeta
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
     * @StoreAssert\Location(groups={"edit"})
     * @Assert\Length(
     *      min = "3",
     *      minMessage = "La ville de votre boutique doit faire au moins {{ limit }} caractères",
     *      groups={"edit"}
     * )
     * @ORM\Column(name="city", type="string", length=300, nullable=true)
     */
    protected $city;

    /**
     * @var string
     * @StoreAssert\Location(groups={"edit"})
     * @Assert\Length(
     *      min = "5",
     *      max = "5",
     *      minMessage = "Le code postal de votre boutique doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le code postal de votre boutique ne peut pas être plus long que {{ limit }} caractères",
     *      groups={"edit"}
     * )
     * @ORM\Column(name="zipcode", type="string", length=300, nullable=true)
     */
    protected $zipcode;

    /**
     * @var string
     * @Assert\Length(
     *      min = "6",
     *      minMessage = "L'adresse de votre boutique doit faire au moins {{ limit }} caractères",
     *      groups={"edit"}
     * )
     * @ORM\Column(name="address", type="string", length=300, nullable=true)
     */
    protected $address;

    /**
     * @var string
     * @Assert\Regex(
     *  pattern="/^\+?\s*(\d+[ \.-]?){8,}$/",
     *  message = "Le téléphone n'est pas valide",
     *  groups={"edit"}
     * )
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     * @Assert\Url(
     *  message = "L'url n'est pas valide",
     *  groups={"edit"}
     * )
     * @ORM\Column(name="website", type="string", length=300, nullable=true)
     */
    protected $website;

    /**
     * @var string
     * @Assert\Length(
     *      min = "15",
     *      minMessage = "Le retou du produit doit faire au moins {{ limit }} caractères",
     *      groups={"suscribe", "edit"}
     * )
     * @ORM\Column(name="retour", type="text", nullable=true)
     */
    protected $retour;

    /**
     * @var string
     * @Assert\Length(
     *      min = "15",
     *      minMessage = "A propos de vous doit faire au moins {{ limit }} caractères",
     *      groups={"suscribe", "edit"}
     * )
     *  @ORM\Column(name="propos", type="text", nullable=true)
     */
    protected $propos;

    /**
     * @var string
     *
     * @ORM\Column(name="delai", type="text", nullable=true)
     */
    protected $delai;

    /**
     * @var float
     *
     * @ORM\Column(name="longituide", type="float", precision=10, scale=0, nullable=true)
     */
    protected $longitude;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    protected $latitude;

    /**
     * @var boolean
     *
     * @ORM\Column(name="optin", type="boolean", nullable=true)
     */
    protected $optin;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_activity", type="integer", nullable=true)
     */
    protected $lastActivity;

    /**
     * @var string
     * @Assert\Length(
     *      min = "15",
     *      minMessage = "Les mentions légales doivent faire au moins {{ limit }} caractères",
     *      groups={"suscribe", "edit"}
     * )
     * @ORM\Column(name="mention", type="text", nullable=true)
     */
    protected $mention;

    /**
     * @var string
     * @Assert\Length(
     *      min = "15",
     *      minMessage = "Les conditions d'expéditions doivent faire au moins {{ limit }} caractères",
     *      groups={"suscribe", "edit"}
     * )
     * @ORM\Column(name="expedition", type="text", nullable=true)
     */
    protected $expedition;

    /**
     * @var string
     * @Assert\Regex(
     *     message = "L'url DaWanda n'est pas valide",
     *     groups={"edit"},
     *     pattern="/^http:\/\/fr.dawanda.com/"
     * ))
     * @ORM\Column(name="dawanda", type="string", length=300, nullable=true)
     */
    protected $dawanda;

    /**
     * @var string
     * @Assert\Regex(
     *     message = "L'url ALittleMarket n'est pas valide",
     *     groups={"edit"},
     *     pattern="/^http:\/\/www.alittlemarket.com/"
     * ))
     * @ORM\Column(name="littlemarket", type="string", length=300, nullable=true)
     */
    protected $littlemarket;

    /**
     * @var \Jeweler
     *
     * @ORM\OneToOne(targetEntity="Jeweler", inversedBy="meta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="jeweler_id", referencedColumnName="id")
     * })
     */
    protected $jeweler;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->optin = false;
        $this->delai = "48h.";
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
     * Set city
     *
     * @param string $city
     * @return JewelerMeta
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return JewelerMeta
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return JewelerMeta
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return JewelerMeta
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set retour
     *
     * @param string $retour
     * @return JewelerMeta
     */
    public function setRetour($retour)
    {
        $this->retour = $retour;

        return $this;
    }

    /**
     * Get retour
     *
     * @return string
     */
    public function getRetour()
    {
        return $this->retour;
    }

    /**
     * Set propos
     *
     * @param string $propos
     * @return JewelerMeta
     */
    public function setPropos($propos)
    {
        $this->propos = $propos;

        return $this;
    }

    /**
     * Get propos
     *
     * @return string
     */
    public function getPropos()
    {
        return $this->propos;
    }

    /**
     * Set delai
     *
     * @param string $delai
     * @return JewelerMeta
     */
    public function setDelai($delai)
    {
        $this->delai = $delai;

        return $this;
    }

    /**
     * Get delai
     *
     * @return string
     */
    public function getDelai()
    {
        return $this->delai;
    }

    /**
     * Set longituide
     *
     * @param float $longituide
     * @return JewelerMeta
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longituide
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return JewelerMeta
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set optin
     *
     * @param boolean $optin
     * @return JewelerMeta
     */
    public function setOptin($optin)
    {
        $this->optin = $optin;

        return $this;
    }

    /**
     * Get optin
     *
     * @return boolean
     */
    public function getOptin()
    {
        return $this->optin;
    }

    /**
     * Set lastActivity
     *
     * @param integer $lastActivity
     * @return JewelerMeta
     */
    public function setLastActivity($lastActivity)
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }

    /**
     * Get lastActivity
     *
     * @return integer
     */
    public function getLastActivity()
    {
        return $this->lastActivity;
    }

    /**
     * Set mention
     *
     * @param string $mention
     * @return JewelerMeta
     */
    public function setMention($mention)
    {
        $this->mention = $mention;

        return $this;
    }

    /**
     * Get mention
     *
     * @return string
     */
    public function getMention()
    {
        return $this->mention;
    }

    /**
     * Set expedition
     *
     * @param string $expedition
     * @return JewelerMeta
     */
    public function setExpedition($expedition)
    {
        $this->expedition = $expedition;

        return $this;
    }

    /**
     * Get expedition
     *
     * @return string
     */
    public function getExpedition()
    {
        return $this->expedition;
    }

    /**
     * Set dawanda
     *
     * @param string $dawanda
     * @return JewelerMeta
     */
    public function setDawanda($dawanda)
    {
        $this->dawanda = $dawanda;

        return $this;
    }

    /**
     * Get dawanda
     *
     * @return string
     */
    public function getDawanda()
    {
        return $this->dawanda;
    }

    /**
     * Set littlemarket
     *
     * @param string $littlemarket
     * @return JewelerMeta
     */
    public function setLittlemarket($littlemarket)
    {
        $this->littlemarket = $littlemarket;

        return $this;
    }

    /**
     * Get littlemarket
     *
     * @return string
     */
    public function getLittlemarket()
    {
        return $this->littlemarket;
    }

    /**
     * Set jeweler
     *
     * @param \Store\BackendBundle\Entity\Jeweler $jeweler
     * @return JewelerMeta
     */
    public function setJeweler(\Store\BackendBundle\Entity\Jeweler $jeweler = null)
    {
        $this->jeweler = $jeweler;

        return $this;
    }


    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return JewelerMeta
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
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
     * Retourne le contenu
     */
    public function __toString()
    {
        return $this->id;
    }


}