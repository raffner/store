<?php

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 10/04/15
 * Time: 16:28
 */

class CategoryRepository extends EntityRepository{

    public function getCategoriesByUser($user = null){
        $query = $this->getEntityManager()
            ->createQuery(
                 "SELECT c
                  FROM StoreBackendBundle:Category c
                  WHERE c.jeweler = :user"
            )
            ->setParameter("user", $user);

        return $query->getResult();


    }

    public function getCountByUser($user = null){
        //Compte le nombre de catégories pour un bijoutier
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT COUNT(c) AS nb
                 FROM StoreBackendBundle:Category c
                 WHERE c.jeweler = :user"
            )
            ->setParameter('user', $user);


        return $query->getOneOrNullResult();
    }


public function getProductsInCategoriesByUser($user = null){
    //Afficher le nombre de produits par catégorie
    $query = $this->getEntityManager()
        ->createQuery(
            "SELECT c
             FROM StoreBackendBundle:Category c
             JOIN c.product p
             WHERE p.jeweler = :user
             "
        )
        ->setParameter("user", $user);

    return $query->getResult();


}




}
