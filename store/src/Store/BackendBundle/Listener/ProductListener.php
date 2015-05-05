<?php

namespace Store\BackendBundle\Listener;


use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Store\BackendBundle\Entity\Product;
use Store\BackendBundle\Notification\Notification;

/**
 * Class ProductListener
 * @package Store\BackendBundle\ProductListener
 */
class ProductListener
{
    /**
     * @var Notification
     */
    protected $notification;

   /**
     * @var Notification
     */
    protected $em;


    /**
     * Constructeur qui reçoie en argument le service Notification
     * On récupère le manager de doctrine en 2eme argument
     * On ne peut pas injecté un service déjà utilisé par les tags associé à ce service
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Cette methode sera appelé depuis mon services.yml
     * ET reçoie en argument mon evenement Doctrine 2
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {

        // Je récupère mon objet après modification (update)
        $entity = $args->getEntity();
        $em =  $args->getEntityManager(); // récupérer l'Entité Manager

        // Si mon objet est un objet de mon entité Product
        if ($entity instanceof Product) {

            // quand la quantité sera égal à 1
            if($entity->getQuantity() == 1){
                $this->notification->notify($entity->getId(),
                        'Attention, votre produit '.$entity->getTitle().'  a une seule quantité',
                        'product', 'danger');
            }

            // si ma quantité est < 5
            else if($entity->getQuantity() < 5 ){
                // je notifie la quantité de ce produit
                // avec la methode notify()
                $this->notification->notify(
                    $entity->getId(),
                    'Attention, votre produit '.$entity->getTitle().'  a un stocke bientôt épuisé',
                    'product',
                    'warning'
                );
            }



        }
    }

    /**
     * Avant la modification de mon objet
     * @param LifecycleEventArgs $args
     * Philippe Vincent: date_updated = NULL
     */
    public function preUpdate(LifecycleEventArgs $args){


    }

    /**
     * Cette methode sera appelé depuis mon services.yml
     * ET reçoie en argument mon evenement Doctrine
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        // appel d'une methode dans une autre: appel de la methode postUpdate()
       $this->postUpdate($args);

    }





}