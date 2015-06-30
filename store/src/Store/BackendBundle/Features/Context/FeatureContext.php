<?php
namespace Store\BackendBundle\Features\Context;


use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;



class FeatureContext extends MinkContext implements KernelAwareContext
{

    /**
     * @var Kerner of Sf2
     */
    protected $kernel;


    /**
     * Initalize Kernel Sf2
     * @param KernelInterface $kernelInterface
     */
    public function setKernel(KernelInterface $kernelInterface)
    {
        $this->kernel = $kernelInterface;
    }

    /**
     * @Given /^I can access service container$/
     */
    public function iCanAccessServiceContainer()
    {
        $container = $this->kernel->getContainer();
        return $container->getParameter('whatever');
    }

    /**
     * @Given /^I can access entity manager$/
     */
    public function iCanAccessEntityManager()
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        // So on
    }

    /**
     * @Given /^I can access repository$/
     */
    public function iCanAccessRepository()
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $repo = $em->getRepository('WhateverBundle:WhateverEntity');
        // So on
    }
}