<?php

namespace Store\BackendBundle\Listener;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class AuthenticationListener
 * @package Store\BackendBundle\Listener
 */
class AuthenticationListener
{

    /**
     * @var EntityManager|null
     */
    protected $em = null;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $em, SecurityContextInterface $securityContext)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;

    }


    /**
     * onAuthenticationSuccess
     *
     * @author 	Joe Sexton <joe@webtipblog.com>
     * @param 	InteractiveLoginEvent $event
     */
    public function onAuthenticationSuccess( InteractiveLoginEvent $event )
    {
        $now = new \DateTime('now');
        $user =$this->securityContext->getToken()->getUser();
        $user->setdateAuth($now);

        $this->em->persist($user);
        $this->em->flush();
    }



}