<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="villes")
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\VillesRepository")
 */
class Villes
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
     *
     * @ORM\Column(name="nom_ville", type="string", length=100, nullable=true)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_ville_maj", type="string", length=100, nullable=true)
     */
    protected $maj;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=100, nullable=true)
     */
    protected $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    protected $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    protected $latitude;



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
     * Set nom
     *
     * @param string $nom
     * @return Villes
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set cp
     *
     * @param string $cp
     * @return Villes
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Villes
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
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
     * @return Villes
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
     * Set maj
     *
     * @param string $maj
     * @return Villes
     */
    public function setMaj($maj)
    {
        $this->maj = $maj;

        return $this;
    }

    /**
     * Get maj
     *
     * @return string 
     */
    public function getMaj()
    {
        return $this->maj;
    }
}
