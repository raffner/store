<?php

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;


class OrdersRepository extends EntityRepository{

    /**
     * @param null $user
     * @return array
     */
    public function getOrdersByUser($user = null){
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT p
                      FROM StoreBackendBundle:Comment p
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
        //Compte le nombre de catégories pour un bijoutier
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT COUNT(o) AS nb
                 FROM StoreBackendBundle:Orders o
                 WHERE o.jeweler = :user"
            )
            ->setParameter('user', $user);


        return $query->getOneOrNullResult();
    }

    public function getCountOrdersByUser($user = null){
        //Compte le chiffre d'affaires un bijoutier
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT SUM(o.total) AS total
                 FROM StoreBackendBundle:Orders o
                 WHERE o.jeweler = :user"
            )
            ->setParameter('user', $user);


        return $query->getOneOrNullResult();
    }


    //les cinq dernières commandes

    public function getLastOrdersByUser($user = null){
        //Affiche
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT o
                 FROM StoreBackendBundle:Orders o
                 WHERE o.jeweler = :user
                 ORDER by o.date
                 "
            )
            ->setMaxResults(5)
            ->setParameter('user', $user);




        return $query->getResult();
    }

}