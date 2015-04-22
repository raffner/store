<?php
/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 21/04/15
 * Time: 11:27
 */

namespace Store\BackendBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JewelerRepository extends EntityRepository implements UserProviderInterface {

    /**
     * Méthode de chargement de l'utilisateur selon son nom ou son email
     */
    public function loadUserByUsername($username)
    {
        $q = $this
            ->createQueryBuilder('j')
            ->select('j, g')
            ->leftJoin('j.groups', 'g')
            ->where('j.username = :username OR j.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery();
    /**
     * Essayer de récupérer un utilisateur avec try{] catch()
     */
        try{
            /**
             * La méthode query lance une exception s'il n'y a pas de résultat
             */
            /**
             * Ne retorune qu'un seul résultat avec la méthode getSingleResult
             */
            $user = $q->getSingleResult();
        }
         /**
         * Si aucun résultat, on retorune alors auncun utilisateur et non pas null
         */

        catch(NoResultException $e){
            return null;
         }
        return $user;
    }


        /**
         * @param UserInterface $user
         * @throws \Symfony\Component\Security\Core\Exception\UnsupportedUserException
         * Rafraîchi l'utilisateur par son token à chaque requête
         * A chaque requête, le rafraîchissement de la session se fait par le token
         *
         */
        public function refreshUser(UserInterface $user)
        {
            $class = get_class($user);
            if (!$this->supportsClass($class)){
                throw new UnsupportedUserException(
                    sprintf(
                        'Instances of "%s" are not supported.',
                        $class
                    )
                );

            }
            return $this->find($user->getId());
        }

    /**
     * @param string $class
     * @return bool
     * Méthode qui permet de déclarer cette classe repository
     *
     */

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }
}