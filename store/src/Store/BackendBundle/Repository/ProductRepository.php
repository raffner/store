<?php

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 10/04/15
 * Time: 16:28
 */

class ProductRepository extends EntityRepository{

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
}