<?php


namespace Store\BackendBundle\Statistics;
use Doctrine\ORM\EntityManager;


/**
 * Class DatasDoctrineFactory
 * @package Store\BackendBundle\Statistics
 */
class DatasDoctrineFactory
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Constructor
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em){
        $this->em = $em;
    }


    /**
     * @param $user
     * @param bool $hydratate
     * @return mixed
     */
    public function getProductByUser($user, $hydratate = true){

        if($hydratate){
            $query = $this->getEntityManager()
                ->createQuery(
                    "
                 SELECT p
                 FROM StoreBackendBundle:Product p
                 WHERE p.jeweler = :jew"
                )
                ->setParameter('jew', $user);
            return $query->getResult();

        }else{
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
    }


}