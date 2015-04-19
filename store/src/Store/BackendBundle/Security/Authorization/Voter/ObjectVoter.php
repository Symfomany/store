<?php

// src/Acme/DemoBundle/Security/Authorization/Voter/ClientIpVoter.php
namespace Store\BackendBundle\Security\Authorization\Voter;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ObjectVoter implements VoterInterface
{
    /**
     * Injecting dependance
     * @param ContainerInterface $container
     * @param array $blacklistedIp
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container     = $container;
    }

    /**
     * Get ATtribute of User
     * @param string $attribute
     * @return bool
     */
    public function supportsAttribute($attribute)
    {
        return true;
    }

    /**
     * Support All CLass
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return true;
    }

    /**
     * Voter
     * @param TokenInterface $token
     * @param null|object $object
     * @param array $attributes
     * @return int
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {

    }
}