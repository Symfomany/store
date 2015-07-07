<?php

namespace Store\BackendBundle\Listener;

use Doctrine\ORM\EntityManager;
use Store\BackendBundle\Notification\Notification;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class AuthentificationListener.
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
     * avec 2 arguments: l'Entité Manager et le Contexte de Sécurité.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $em,
            SecurityContextInterface $securityContext,
            Notification $notification,
            Session $session,
            Router $router)
    {
        //je stocke dans 2 attributs les services récupérés
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->notification = $notification;
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * Methode qui est déclenché après l'événement InteractiveLogin
     * qui est  l'action de login dans la sécurité.
     *
     * @param InteractiveLoginEvent $event
     */
    public function onAuthenticationSuccess(InteractiveLoginEvent $event)
    {
        $now = new \DateTime('now');
        // récupére l'utilisateur  courant connecté
        $user = $this->securityContext->getToken()->getUser();

        //recupere tous les produits de l'utilisateur via le repository ProductRepository
        // et via getProductsQuantityIsLower() qui on une quantité < 5
        $products = $this->em->getRepository('StoreBackendBundle:Product')->getProductsQuantityIsLower($user);

        //pour chaque produit
        foreach ($products as $product) {
            // si la quantité du produit est égal à 1
            if ($product->getQuantity() == 1) {
                $this->notification->notify($product->getId(),
                    'Attention, votre produit '.$product->getTitle().'  a une seule quantité',
                    'product', 'danger');
            } else {
                $this->notification->notify($product->getId(),
                    'Attention, votre produit '.$product->getTitle().'  a quantité bientot épuisé',
                    'product', 'warning');
            }
        }

        // declencher une notification dans mes produits
        $date = $user->getDateAuth();
        $oldyear = new \DateTime('-2 month');

        $route = 'store_backend_index';

        // Long time to control use account
        if ($date < $oldyear || !$date) {
            $this->session->set('first', true);
            $route = 'store_backend_jeweler_myaccount';
        }

        // met à jour la date de connexion de l'utilisateur
        $user->setDateAuth($now);

        //enregistre mon utilisateur avec sa date modifié
        $this->em->persist($user);
        $this->em->flush();

        return new RedirectResponse($this->router->generate($route));
    }
}
