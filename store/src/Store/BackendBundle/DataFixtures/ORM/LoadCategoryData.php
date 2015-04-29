<?php

namespace Store\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Store\BackendBundle\Entity\Category;
use Store\BackendBundle\Entity\Product;


/**
 * Cette classe me permettra de charger des catégories en base de données
 * Class LoadCategoryData
 * @package Store\BackendBundle\DataFixtures\ORM
 */
class LoadCategoryData implements FixtureInterface{


    /*
     * Cette méthode me permettra de charger mes données (catégories)
     */
    public function load(ObjectManager $manager){

        $categorie = new Category();
        $categorie->setTitle('colliers magnifiques');
        $categorie->setDescription('Jolie description de vos magnifiques colliers');

        $categorie2 = new Category();
        $categorie2->setTitle('colliers maginifiques');
        $categorie2->setDescription('Jolie description de vos magnifiques colliers');

        $product = new Product();
        //Associer un jeweler à mon produit avec getRepository
        $jeweler = $manager->getRepository('StoreBackendBundle:Jeweler')->find(1);
        $product->addCategory($categorie);
        $product->setJeweler($jeweler);
        $product->setTitle('Collier Azur');
        $product->setDescription('Collier AzurCollier Azur Collier Azur');

        $manager->persist($product);
        $manager->persist($categorie);
        $manager->persist($categorie2);

        $manager->flush();
    }
}