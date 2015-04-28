<?php

namespace Store\BackendBundle\Listener;


use Doctrine\ORM\EntityManager;
use Store\BackendBundle\Notification\Notification;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class AuthentificationListener
 * @package Store\BackendBundle\Listener
 */
class AuthentificationListener
{
    /**
     * @var EntityManager|null
     */
    protected $em;

    /**
     * @var null|SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var null|Notification
     */
    protected $notification;

    /**
     * Le constructeur de ma classe
     * avec 2 arguments: l'Entité Manager et le Contexte de Sécurité
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $em,
            SecurityContextInterface $securityContext,
            Notification $notification)
    {
        //je stocke dans 2 attributs les services récupérés
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->notification = $notification;
    }

    /**
     * Methode qui est déclenché après l'événement InteractiveLogin
     * qui est  l'action de login dans la sécurité
     * @param InteractiveLoginEvent $event
     */
    public function onAuthenticationSuccess(InteractiveLoginEvent $event)
    {
        $now = new \DateTime('now');
        // récupére l'utilisateur  courant connecté
        $user =$this->securityContext->getToken()->getUser();

        //recupere tous les produits de l'utilisateur via le repository ProductRepository
        // et via getProductsQuantityIsLower() qui on une quantité < 5
        $products = $this->em->getRepository('StoreBackendBundle:Product')->
            getProductsQuantityIsLower($user);

        //pour chaque produit
        foreach($products as $product){
            // si la quantité du produit est égal à 1
            if($product->getQuantity() == 1){
                $this->notification->notify($product->getId(),
                    'Attention, votre produit '.$product->getTitle().'  a une seule quantité',
                    'product', 'danger');
            }else{
                $this->notification->notify($product->getId(),
                    'Attention, votre produit '.$product->getTitle().'  a quantité bientot épuisé',
                    'product', 'warning');
            }
        }


        // declencher une notification dans mes produits

        // met à jour la date de connexion de l'utilisateur
        $user->setDateAuth($now);

        //enregistre mon utilisateur avec sa date modifié
        $this->em->persist($user);
        $this->em->flush();
    }



}