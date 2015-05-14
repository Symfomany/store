<?php

namespace Store\BackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * Jeweler Class
 * Use AdvancedUserInterface
 * @ORM\Table(name="jeweler", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\JewelerRepository")
 * @UniqueEntity(fields="username", message="Votre login est déjà existant", groups={"suscribe", "edit"})
 * @UniqueEntity(fields="email", message="Votre email est déjà existant", groups={"suscribe", "edit"})
 * @ORM\HasLifecycleCallbacks()
 */
class Jeweler implements  AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "L'email ne doit pas etre vide",
     *     groups={"suscribe", "edit"}
     * )
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas un email valide.",
     *     checkMX = true,
     *     groups={"suscribe", "edit"}
     * )
     * @ORM\Column(name="email", type="string", length=150, nullable=true)
     */
    protected $email;
    
    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "Le pseudonyme ne doit pas etre vide",
     *     groups={"suscribe", "edit"}
     * )
     * @Assert\Regex(
     *     message = "Le pseudonyme doit être valide (caractères alphanumérique au minimum de 4)",
     *     groups={"suscribe", "edit"},
     *     pattern="/^[a-zA-Z._]{4,60}/"
     * ))
     * @ORM\Column(name="username", type="string", length=150, nullable=true)
     */
    protected $username;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "Le mot de passe ne doit pas etre vide",
     *     groups={"suscribe"}
     * )
     * @Assert\Length(
     *      min = "6",
     *      max = "50",
     *      minMessage = "Le mot de passe doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le mot de passe ne peut pas être plus long que {{ limit }} caractères",
     *      groups={"suscribe"}
     * )
     * @ORM\Column(name="password", type="string", length=300, nullable=true)
     */
    protected $password;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "Le titre de votre boutique ne doit pas etre vide",
     *     groups={"suscribe", "edit"}
     * )
     * @Assert\Regex(
     *     message = "Le nom de votre boutique doit être valide (caractères alphanumérique au minimum de 4)",
     *     groups={"edit"},
     *     pattern="/^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]{4,70}/"
     * ))
     * @ORM\Column(name="title", type="string", length=300, nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "La description ne doit pas etre vide",
     *     groups={"suscribe", "edit"}
     * )
     * @Assert\Length(
     *      min = "15",
     *      minMessage = "La description doit faire au moins {{ limit }} caractères",
     *      groups={"suscribe", "edit"}
     * )
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=300, nullable=true)
     */
    protected $image;

    /**
     * @var integer
     * @Assert\Choice(choices = {"1", "2", "3", "4", "5", "6", "7", "8", "9", "10"}, message = "Choisissez un type valide.",  groups={"edit"})
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    protected $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    protected $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=300, nullable=true)
     */
    protected $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=300, nullable=true)
     */
    protected $token;

    /**
     * @var string
     *
     * @ORM\Column(name="email_canonical", type="string", length=300, nullable=true)
     */
    protected $emailCanonical;

    /**
     * @var boolean
     *
     * @ORM\Column(name="credentials_expired", type="boolean", nullable=true)
     */
    protected $credentialsExpired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="credentials_expire_at", type="datetime", nullable=true)
     */
    protected $credentialsExpireAt;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_token", type="string", length=300, nullable=true)
     */
    protected $confirmationToken;

    /**
     * @var string
     *
     * @ORM\Column(name="password_requested_at", type="string", length=300, nullable=true)
     */
    protected $passwordRequestedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="fid", type="integer", nullable=true)
     */
    protected $fid;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=30, nullable=true)
     */
    protected $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accountNonLocked", type="boolean", nullable=true)
     */
    protected $accountnonlocked;

    /**
     * @var boolean
     *
     * @ORM\Column(name="roles", type="string", nullable=true)
     */
    protected $roles;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accountNonExpired", type="boolean", nullable=true)
     */
    protected $accountnonexpired;

    /**
     * @var boolean
     * @Assert\Valid
     * @ORM\OneToOne(targetEntity="JewelerMeta", mappedBy="jeweler")
     **/
    protected $meta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    protected $dateCreated;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=true)
     */
    protected $dateUpdated;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_auth", type="datetime", nullable=true)
     */
    protected $dateAuth;
    

    /**
     * @ORM\ManyToMany(targetEntity="Groups", inversedBy="jeweler")
     * @ORM\JoinTable(name="jeweler_groups",
     *   joinColumns={
     *     @ORM\JoinColumn(name="jeweler_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="groups_id", referencedColumnName="id")
     *   }
     * )
     *
     */
    protected $groups;


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
        $this->dateCreated = new \DateTime('now');
        $this->dateUpdated = new \DateTime('now');
        $this->type = 1;
        $this->enabled = false;
        $this->accountnonexpired = 1;
        $this->accountnonlocked = 1;
        $this->credentialsExpired = 1;
        $this->locked = 0;
        $this->expired = 0;
        $this->salt = md5(uniqid(null, true));
        $this->token = sha1(uniqid(null, true).microtime());
        $this->groups = new ArrayCollection();

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
     * Set email
     *
     * @param string $email
     * @return Jeweler
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Jeweler
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Jeweler
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
     * @return Jeweler
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
     * @return Jeweler
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
     * Set type
     *
     * @param integer $type
     * @return Jeweler
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Jeweler
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Jeweler
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Jeweler
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set emailCanonical
     *
     * @param string $emailCanonical
     * @return Jeweler
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;

        return $this;
    }

    /**
     * Get emailCanonical
     *
     * @return string 
     */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }

    /**
     * Set credentialsExpired
     *
     * @param boolean $credentialsExpired
     * @return Jeweler
     */
    public function setCredentialsExpired($credentialsExpired)
    {
        $this->credentialsExpired = $credentialsExpired;

        return $this;
    }

    /**
     * Get credentialsExpired
     *
     * @return boolean 
     */
    public function getCredentialsExpired()
    {
        return $this->credentialsExpired;
    }

    /**
     * Set credentialsExpireAt
     *
     * @param \DateTime $credentialsExpireAt
     * @return Jeweler
     */
    public function setCredentialsExpireAt($credentialsExpireAt)
    {
        $this->credentialsExpireAt = $credentialsExpireAt;

        return $this;
    }

    /**
     * Get credentialsExpireAt
     *
     * @return \DateTime 
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     * @return Jeweler
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Get confirmationToken
     *
     * @return string 
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set passwordRequestedAt
     *
     * @param string $passwordRequestedAt
     * @return Jeweler
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    /**
     * Get passwordRequestedAt
     *
     * @return string 
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * Set fid
     *
     * @param integer $fid
     * @return Jeweler
     */
    public function setFid($fid)
    {
        $this->fid = $fid;

        return $this;
    }

    /**
     * Get fid
     *
     * @return integer 
     */
    public function getFid()
    {
        return $this->fid;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Jeweler
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
     * Set accountnonlocked
     *
     * @param boolean $accountnonlocked
     * @return Jeweler
     */
    public function setAccountnonlocked($accountnonlocked)
    {
        $this->accountnonlocked = $accountnonlocked;

        return $this;
    }

    /**
     * Get accountnonlocked
     *
     * @return boolean 
     */
    public function getAccountnonlocked()
    {
        return $this->accountnonlocked;
    }

    /**
     * Set accountnonexpired
     *
     * @param boolean $accountnonexpired
     * @return Jeweler
     */
    public function setAccountnonexpired($accountnonexpired)
    {
        $this->accountnonexpired = $accountnonexpired;

        return $this;
    }

    /**
     * Get accountnonexpired
     *
     * @return boolean 
     */
    public function getAccountnonexpired()
    {
        return $this->accountnonexpired;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Jeweler
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
     * Set meta
     *
     * @param \Store\BackendBundle\Entity\JewelerMeta $meta
     * @return Jeweler
     */
    public function setMeta(\Store\BackendBundle\Entity\JewelerMeta $meta = null)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Get meta
     *
     * @return \Store\BackendBundle\Entity\JewelerMeta 
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *        return $this->groups->toArray();
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
//        return array('ROLE_JEWELER');
        //e retourne mon attrribut groups en tableau :
        // ArrayCollection => Array
        return $this->groups->toArray();
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return null;
    }

    /**
     * Mis en session par le Token
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * Extraction des données mise en ession
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            ) = unserialize($serialized);
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        return $this->username === $user->getUsername();
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Jeweler
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Verification is Account is not expired
     * Si le compte n'est pas expiré
     * @return bool
     */
    public function isAccountNonExpired()
    {
        $datecreated = $this->dateCreated;
        $dateoldyear = new \DateTime('-1 year');

        if($datecreated < $dateoldyear ){
            return false;
        }

        return true;
    }

    /**
     * Verification is Account is not locked
     * SI le compte n'est pas verouillé
     * @return bool
     */
    public function isAccountNonLocked()
    {
        return $this->accountnonlocked;
    }

    /**
     * Verification account  credentials is not expired
     * Si c'est droit on expirés
     * @return bool
     */
    public function isCredentialsNonExpired()
    {
        return $this->credentialsExpired;
    }

    /**
     * Verification account is not enabled
     * Si l'utilisateur a activer son compte
     * @return bool|int
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Convertis un objet jeweler en chaine de charactères
     * @return string
     */
    public function __toString(){

        return $this->title;
    }


    /**
     * Set roles
     *
     * @param string $roles
     * @return Jeweler
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }



    /**
     * Add groups
     *
     * @param \Store\BackendBundle\Entity\Groups $groups
     * @return Jeweler
     */
    public function addGroup(\Store\BackendBundle\Entity\Groups $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Store\BackendBundle\Entity\Groups $groups
     */
    public function removeGroup(\Store\BackendBundle\Entity\Groups $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }



    /**
     * @Assert\Callback(groups={"suscribe"})
     * use Symfony\Component\Validator\Context\ExecutionContextInterface;
     */
    public function validate(ExecutionContextInterface $context)
    {
        $val = $this->getUsername();
        if(!empty($val)) {
            if (($this->getUsername() == $this->getPassword())) {
                $context->addViolationAt(
                    'username',
                    'Votre login ne doit pas être identique à votre mot de passe',
                    array(),
                    null
                );
            }
        }

        $val = $this->getEmail();
        if(!empty($val)) {
            if (($this->getUsername()  == $this->getEmail())) {
                $context->addViolationAt(
                    'email',
                    'Votre email ne doit pas être identique à votre login',
                    array(),
                    null
                );
            }
        }

    }

    /**
     * Set dateAuth
     *
     * @param \DateTime $dateAuth
     * @return Jeweler
     */
    public function setDateAuth($dateAuth)
    {
        $this->dateAuth = $dateAuth;

        return $this;
    }

    /**
     * Get dateAuth
     *
     * @return \DateTime 
     */
    public function getDateAuth()
    {
        return $this->dateAuth;
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
        return 'uploads/profil';
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
}
