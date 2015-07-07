<?php

namespace Store\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Store\BackendBundle\Entity\Category;
use Store\BackendBundle\Entity\Product;

/**
 * Cette classe me permettra de charger des catégories
 * en base de données
 * Class LoadCategoryData.
 */
class LoadCategoryData implements FixtureInterface
{
    /**
     * Cette methode me permettra de charger mes données
     * (catégories)
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // Ma 1ere catégorie
        $categorie = new Category();
        $categorie->setTitle('Colliers Magnifiques');
        $categorie->setDescription('Jolie description
        de vos magnifiques colliers');

        // Ma 2ere catégorie
        $categorie2 = new Category();
        $categorie2->setTitle('Bracelets Glamours');
        $categorie2->setDescription('Belle description
        complete de vos bracelets glamours');

        // Mon 1er produit
        $product = new Product();
        // Associé un jeweler à mon produit
        // Je recupere mon jeweler numéro 1
        $jeweler = $manager->getRepository('StoreBackendBundle:Jeweler')
            ->find(1);
        $product->addCategory($categorie);
        $product->setJeweler($jeweler);

        $product->setTitle('Collier Azure Ete');
        $product->setDescription('Collier composé
        de perles nacrées avec vernissage et finition
        de pierres Swarovski');
        $product->setComposition('Perles nacrées, Pierres précieuses');
        $product->setActive(true);
        $product->setCover(true);

        $manager->persist($product);
        $manager->persist($categorie);
        $manager->persist($categorie2);
        $manager->flush();
    }
}
