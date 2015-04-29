<?php

namespace Store\BackendBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{


    /**
     * Get all product of an user
     * @return mixed
     */
    public function getProductByUser($user = null){
        $query = $this->getEntityManager()
            ->createQuery(
                "
                 SELECT p
                 FROM StoreBackendBundle:Product p
                 WHERE p.jeweler = :jew"
            )
            ->setParameter('jew', $user);

        //je dois retourner la requête pour le tri
        return $query;
    }


    /**
     * Get all product of an user who quantity less than
     * @return mixed
     */
    public function getProductsQuantityIsLower($user = null){
        $query = $this->getEntityManager()
            ->createQuery(
                "
                 SELECT p
                 FROM StoreBackendBundle:Product p
                 WHERE p.jeweler = :jeweler
                 AND p.quantity < 5"
            )
            ->setParameter('jeweler', $user);

        return $query->getResult();
    }

    /**
     * Count All Product
     * SELECT COUNT(id)
     * FROM `product`
     * WHERE `jeweler_id` = 1
     * @return mixed
     */
    public function getCountByUser($user = null){
        // compte le nb de produits pour 1 bijoutier
        $query = $this->getEntityManager()
            ->createQuery(
                "
                 SELECT COUNT(p) AS nb
                 FROM StoreBackendBundle:Product p
                 WHERE p.jeweler = :user"
            )
            ->setParameter('user', $user);

        // retourne 1 résultat ou null
        return $query->getOneOrNullResult();
    }

    /**
     * Count All Product
     * SELECT COUNT(id)
     * FROM `product`
     * WHERE `jeweler_id` = 1
     * @return mixed
     */
    public function getNbProdEmpty($user = null){
        // compte le nb de produits pour 1 bijoutier
        $query = $this->getEntityManager()
            ->createQuery(
                "
                 SELECT COUNT(p) AS nb
                 FROM StoreBackendBundle:Product p
                 WHERE p.quantity = 0
                 AND p.jeweler = :user"
            )
            ->setParameter('user', $user);

        // retourne 1 résultat ou null
        return $query->getOneOrNullResult();
    }


    /**
     * Count All Product
     * SELECT COUNT(id)
     * FROM `product`
     * WHERE `jeweler_id` = 1
     * @return mixed
     */
    public function getNbLikesByUser($user = null){
        // compte le nb de produits pour 1 bijoutier
        $query = $this->getEntityManager()
            ->createQuery(
                "
                 SELECT COUNT(l) AS nb
                 FROM StoreBackendBundle:Product p
                 JOIN p.likes l
                 WHERE p.jeweler = :user"
            )
            ->setParameter('user', $user);

        // retourne 1 résultat ou null
        return $query->getOneOrNullResult();
    }


    /**
     * DQL Syntax with Form
     * @param int $user
     * @return array
     */
    public function getProductByUserBuilder($user){

        /**
         * Le formulaire ProductType attend un objet createQueryBuilder()
         *  ET NON PAS l'objet createQuery()
         */
        $queryBuilder = $this->createQueryBuilder('c')
            ->where('c.jeweler = :user')
            ->orderBy('c.title', 'ASC')
            ->setParameter('user', $user);

        return $queryBuilder;
    }
}
