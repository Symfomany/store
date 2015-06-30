<?php

namespace Store\BackendBundle\Repository;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * JewelerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JewelerRepository extends EntityRepository implements UserProviderInterface
{


    /**
     * Get jeweler for optin
     * @param null $user
     * @return array
     */
    public function getJewelersOptin($optin = 1){

        $query = $this->getEntityManager()
            ->createQuery(
                "
                 SELECT j
                 FROM StoreBackendBundle:Jeweler j
                 JOIN j.meta m
                 WHERE m.optin = :optin
                "
            )
            ->setParameter('optin', $optin);

        return $query->getResult();

    }


    /**
     * Load Active User by Username or Email
     * Methode de chargement de l'utilisateur: par son email ou username
     * @param string $username
     * @return mixed|UserInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadUserByUsername($username)
    {
        $q = $this
            ->createQueryBuilder('j')
            ->select('j, g')
            ->leftJoin('j.groups', 'g')
            ->where('j.username = :username OR j.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery();

        /**
         * Essayer de récuperer un utilisateur avec try{} catch()
         */
        try {
            // La méthode Query::getSingleResult() lance une exception NoResultException
            // s'il n'y a pas d'entrée correspondante aux critères

            //Me retourne qu'un seul résultat avec la methode getSingleResult()
            $user = $q->getSingleResult();

        } catch (NoResultException $e) {
            // si il n'y a aucun résultat, alors on retourne aucun utilisateur
            throw new UsernameNotFoundException(sprintf('Utilisateur introuvable "%s".', $username), 0, $e);
        }

        return $user;
    }

    /**
     * Rafraichi l'utilisateur par son token
     * Appeller pour Rafraichis l'utilisateur en session par son token à chaque requete: clefs en session
     * A chaque requete , le rafraichisement de la session se faît par le token
     * @param UserInterface $user
     * @return null|object|UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) { //verifie si l'entité liée est supporter par le mecanisme d'authentification avec encodage
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }
        //utilise la methode find() pour retrouver l'utilisateur depuis son ID
            $q = $this
                ->createQueryBuilder('u')
                ->select('u, g')
                ->leftJoin('u.groups', 'g')
                ->where('u.id = :id')
                ->setParameter('id', $user->getId())
                ->getQuery();

        return $q->getSingleResult();
    }

    /**
     * Get User Class for recognize Authentification Class
     * Methode qui permet de declarer cette classe repository
     * comme un Providers au mécanisme de scurité de faire reconnaitre cette classe
     * comme EntityProvider
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }



    /**
     * @param null $user
     * @return array
     */
    public function getJewelersofUser($user = null){

        $query = $this->getEntityManager()
            ->createQuery(
                "
                 SELECT j
                 FROM StoreBackendBundle:Product p
                 JOIN p.jeweler j
                 GROUP BY j.id
                 WHERE p.jeweler = :user
                "
            )
            ->setParameter('user', $user);

        return $query->getResult();

    }
}
