<?php

namespace Store\BackendBundle\Listener;


use Doctrine\ORM\EntityManager;
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
     * Le constructeur de ma classe
     * avec 2 arguments: l'Entité Manager et le Contexte de Sécurité
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $em,
            SecurityContextInterface $securityContext)
    {
        //je stocke dans 2 attributs les services récupérés
        $this->em = $em;
        $this->securityContext = $securityContext;
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

        // met à jour la date de connexion de l'utilisateur
        $user->setDateAuth($now);

        //enregistre mon utilisateur avec sa date modifié
        $this->em->persist($user);
        $this->em->flush();
    }



}