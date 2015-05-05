<?php

namespace Store\BackendBundle\Entity;



use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Group
 * @ORM\Entity
 * @ORM\Table(name="groups")
 */
class Groups  implements RoleInterface {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=300)
     */
    private $name;

    /**
     * @ORM\Column(name="role", type="string", length=300, unique=true)
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="Jeweler", mappedBy="groups")
     */
    private $jeweler;



    // ... getters and setters for each property

    /**
     * @see RoleInterface
     */
    public function getRole()
    {
        return $this->role;
    }



    public function __construct()
    {
        $this->jeweler = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return JewelerGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return JewelerGroup
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }


    /**
     * Add jeweler
     *
     * @param \Store\BackendBundle\Entity\Jeweler $jeweler
     * @return JewelerGroup
     */
    public function addJeweler(\Store\BackendBundle\Entity\Jeweler $jeweler)
    {
        $this->jeweler[] = $jeweler;

        return $this;
    }

    /**
     * Remove jeweler
     *
     * @param \Store\BackendBundle\Entity\Jeweler $jeweler
     */
    public function removeJeweler(\Store\BackendBundle\Entity\Jeweler $jeweler)
    {
        $this->jeweler->removeElement($jeweler);
    }

    /**
     * Get jeweler
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJeweler()
    {
        return $this->jeweler;
    }
}
