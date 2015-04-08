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
     * Get Products of User
     * @param int $user
     * @return array
     */
    public function getProductByUser($user){

        $query = $this->getEntityManager()
                ->createQuery(
                    "
                    SELECT p
                    FROM StoreBackendBundle:Product p
                    WHERE p.jeweler = :user
                    "
                )
            ->setParameter('user', $user);

        return $query->getResult();
    }


    /**
     * Count All Product
     * @return mixed
     */
    public function getCountByUser($user = null){
        $query = $this->getEntityManager()
            ->createQuery(
                "
                 SELECT COUNT(p) AS nb
                 FROM StoreBackendBundle:Product p
                 WHERE p.jeweler = :user"
            )
            ->setParameter('user', $user);

        return $query->getOneOrNullResult();
    }
}
