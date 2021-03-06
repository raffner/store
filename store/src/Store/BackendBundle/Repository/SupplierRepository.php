<?php

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;


class SupplierRepository extends EntityRepository{

    /**
     * @param null $user
     * @return array
     */
    public function getCommentsByUser($user = null){
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT s
                 FROM StoreBackendBundle:Supplier s
                 JOIN s.product p
                 WHERE p.jeweler = :user
                 GROUP by p.jeweler"
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
        //La jointure se fait sur l'attribut de l'entité (ici product) et non pas l'entité
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT COUNT(DISTINCT s) AS nb
                 FROM StoreBackendBundle:Supplier s
                 JOIN s.product p
                 WHERE p.jeweler = :user
                "
            )
            ->setParameter('user', $user);


        return $query->getOneOrNullResult();
    }

}