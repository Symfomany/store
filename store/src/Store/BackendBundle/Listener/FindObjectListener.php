<?php

// src/Acme/DemoBundle/Listener/AcmeExceptionListener.php
namespace Store\BackendBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;


class FindObjectListener
{

    protected $securityContext;


    /**
     * Construct to injecting params
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(SecurityContextInterface $securityContext){
        $this->securityContext = $securityContext;

    }

}