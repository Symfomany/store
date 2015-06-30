<?php

namespace Store\BackendBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ProductRepositoryTest extends WebTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;


    /**
     * Setup Doctrine Entity Manger
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        //je recupere
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }


    /**
     * Test getPostBuTitle
     */
//    public function testgetPostsByTitle()
//    {
//        $products = $this->em
//            ->getRepository('StoreBackendBundle:Product')
//            ->getProductByUser(1);
//
//        $this->assertCount(13, $products->getResult());
//
//    }



}