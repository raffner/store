<?php

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;


class ProductRepository extends EntityRepository{

    /**
     * @param null $user
     * @return array
     */
    public function getProductsByUser($user = null){
      $query = $this->getEntityManager()
            ->createQuery(
          "SELECT p
                FROM StoreBackendBundle:Product p
                WHERE p.jeweler = :user"
          )
          ->setParameter("user", $user);

      return $query->getResult();


    }


    /**
     * @param null $user
     * @return mixed
     */
    public function getCountByUser($user = null){

        //Compte le nombre de produits pour un bijoutier
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT COUNT(p) AS nb
                 FROM StoreBackendBundle:Product p
                 WHERE p.jeweler = :user"
            )
            ->setParameter('user', $user);


         return $query->getOneOrNullResult();
    }

}