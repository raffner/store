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
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT p
                      FROM StoreBackendBundle:CMS p
                      WHERE p.jeweler = :user"
            )
            ->setParameter("user", $user);

        return $query->getResult();


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