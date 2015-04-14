<?php

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;


class CommentRepository extends EntityRepository{

    /**
     * @param null $user
     * @return array
     */
    public function getCommentsByUser($user = null){
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT p
                      FROM StoreBackendBundle:Comment p
                      WHERE p.jeweler = :user"
            )
            ->setParameter("user", $user);

        return $query->getResult();


    }
    public function getCountByUser($user = null){

        //Compte le nombre de produits pour un bijoutier
        //La jointure se fait sur l'attribut de l'entité (ici product) et non pas l'entité
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT COUNT(com) AS nb
                 FROM StoreBackendBundle:Comment com
                 JOIN com.product AS p
                 WHERE p.jeweler = :user"
            )
            ->setParameter('user', $user);


        return $query->getOneOrNullResult();
    }

    public function getLastCountByUser($user = null){
        //Affiche
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT com
                 FROM StoreBackendBundle:Orders com
                 WHERE com.jeweler = :user
                 ORDER by com.date
                 "
            )
            ->setMaxResults(5)
            ->setParameter('user', $user);




        return $query->getResult();
    }


}