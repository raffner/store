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
//        $query = $this->getEntityManager()
//            ->createQuery(
//                "SELECT c
//                 FROM StoreBackendBundle:Category c
//                 WHERE c.jeweler = :user"
//            )
//            ->setParameter("user", $user);

        //J'appelle la méthode getCategoryByUserBuilder qui me retourne un objet queryBuilder
        //Je le transforme ensuite en objet query (requête)
        $query = $this->getCategoryByUserBuilder($user)->getQuery();

        return $query->getResult();


    }

    public function getCategoryByUserBuilder($user){
        /**
         * Le formulaire attend la méthode createQueryBuilder : et non pas l'objet CreateQuery
         * le paramètre (c) est l'alias : dans cette méthode, on se dispense de la requete select from
         */
        $queryBuilder = $this->createQueryBuilder('c')

                ->where('c.jeweler = :user')
                ->orderBy('c.title', 'ASC')
                ->setParameter('user', $user);
        return $queryBuilder;
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
