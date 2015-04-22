<?php

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 10/04/15
 * Time: 16:28
 */

class SliderRepository extends EntityRepository{

    public function getSlidersByUser($user = null){
//        $query = $this->getEntityManager()
//            ->createQuery(
//                "SELECT c
//                 FROM StoreBackendBundle:Slider s
//                 WHERE c.jeweler = :user"
//            )
//            ->setParameter("user", $user);

        //J'appelle la méthode getCategoryByUserBuilder qui me retourne un objet queryBuilder
        //Je le transforme ensuite en objet query (requête)
        $query = $this->getSlidersByUserBuilder($user)->getQuery();

        return $query->getResult();


    }

    public function getSlidersByUserBuilder($user){
        /**
         * Le formulaire attend la méthode createQueryBuilder : et non pas l'objet CreateQuery
         * le paramètre (s) est l'alias : dans cette méthode, on se dispense de la requete select from
         */
        $queryBuilder = $this->createQueryBuilder('s')
            ->join ('s.product', 'p')
            ->where('p.jeweler = :user')
            ->orderBy('s.id', 'ASC')
            ->setParameter('user', $user);
        return $queryBuilder;
    }





}
