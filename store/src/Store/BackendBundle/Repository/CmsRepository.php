<?php

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 10/04/15
 * Time: 16:28
 */

class CmsRepository extends EntityRepository{

    public function getCMSByUser($user = null){
//        $query = $this->getEntityManager()
//            ->createQuery(
//                "SELECT p
//                      FROM StoreBackendBundle:CMS p
//                      WHERE p.jeweler = :user"
//            )
         $query = $this->getCmsByUserBuilder($user)->getQuery();

        //return $query->getResult();: pour utiliser la fonction de tri du bundle knp, je dois non pas envoyer le résultat
        //mais la requête en elle-meme qui devient donc return $query;
        return $query;



    }

    public function getCmsByUserBuilder($user){
        /**
         * Le formulaire atten la méthode createQueryBuilder : et non pas l'objet CreateQuery
         */
        $queryBuilder = $this->createQueryBuilder('cms')

            ->where('cms.jeweler = :user')
            ->orderBy('cms.title', 'ASC')
            ->setParameter('user', $user);
        return $queryBuilder;
    }

    public function getCountByUser($user = null){

        //Compte le nombre de produits pour un bijoutier
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT COUNT(cm) AS nb
                 FROM StoreBackendBundle:CMS cm
                 WHERE cm.jeweler = :user"
            )
            ->setParameter('user', $user);


        return $query->getOneOrNullResult();
    }

}