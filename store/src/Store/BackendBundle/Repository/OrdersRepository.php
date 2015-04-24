<?php

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;


class OrdersRepository extends EntityRepository{

    /**
     * Requête qui me sort les commandes des six derniers mois
     * SELECT COUNT(id) FROM `orders` as o WHERE o.date BETWEEN DATE_SUB(NOW(), INTERVAL 6 month) AND NOW()
     * DATE BEGIN deviendra un dateTime
     */
    public function getOrderGraphByUser($user, $dateBegin){

        //Compter le nombre de commandes pour un jeweler précis et pour une année et un mois précis.
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT COUNT(o) AS nb, DATE_FORMAT(:dateBegin, '%Y-%m') AS d
                      FROM StoreBackendBundle:Orders o
                      WHERE o.jeweler = :user
                      AND MONTH(o.dateCreated) = :month
                      AND YEAR(o.dateCreated) = :year"
            )
        //setParameters permet de regrouper les arguments
            ->setParameters(array(
                'user'=> $user,
                'dateBegin' => $dateBegin->format('Y-m-d'),
                'month' => $dateBegin->format('m'),
                'year' => $dateBegin->format('Y')

            ));

        return $query->getSingleResult();



    }


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