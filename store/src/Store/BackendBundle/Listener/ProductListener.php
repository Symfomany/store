<?php

namespace Store\BackendBundle\Listener;


use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use Store\BackendBundle\Email\Email;
use Store\BackendBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class ProductListener
 * @package Store\BackendBundle\ProductListener
 */
class ProductListener
{

    /**
     * @var EntityManager|null
     */
    protected $email;


    /**
     * @var Session
     */
    protected $session;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(Email $email, Session $session)
    {
        $this->email = $email;
        $this->session = $session;

    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // peut-être voulez-vous seulement agir sur une entité « Product »
        if ($entity instanceof Product) {

            if($entity->getQuantity() < 5 ){
                $this->email->send($entity->getJeweler(), "julien@meetserious.com","StoreBackendBundle:Mail:out.html.twig","Un produit est bientot or stock",
                    $content = "Votre produit ".$entity->getTitle()." a bientot plus de quantité : ".$entity->getQuantity());

                $this->session->set($entity->getId(), "Le produit ".$entity->getTitle()." a bientôt plus de stock");

            }
        }
    }





}