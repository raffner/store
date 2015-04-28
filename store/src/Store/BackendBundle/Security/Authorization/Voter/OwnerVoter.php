<?php
namespace Store\BackendBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 28/04/15
 * Time: 14:40
 */




class OwnerVoter implements VoterInterface{
    /**
     * Cette méthoode me permet de récupérer le ou les attributs envoyés depuis mon contrôleur
     *
     * @param string $attribute An attribute
     *
     * @return bool true if this Voter supports the attribute, false otherwise
     */
    public function supportsAttribute($attribute)
    {
       return true;
    }

    /**
     * Checks if the voter supports the given class.
     *cette méthode me permet de faire des restrictions sur l'utilisation de ce voter
     * @param string $class A class name
     *
     * @return bool true if this Voter can process the class
     */
    public function supportsClass($class)
    {
        return true;    }

    /**
     * Returns the vote for the given parameters.
     * Mécanisme que l'on implémente pour voter les droits er permissions de l'utilisateur
     * This method must return one of the following constants:
     * ACCESS_GRANTED, ACCESS_DENIED, or ACCESS_ABSTAIN.
     *
     * @param TokenInterface $token A TokenInterface instance
     * @param object|null $object The object to secure
     * @param array $attributes An array of attributes associated with the method being invoked
     *
     * @return int either ACCESS_GRANTED, ACCESS_ABSTAIN, or ACCESS_DENIED
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        /**
         * VoterInterface::ACCESS DENIED : accès non permis (403)
         * VoterInterface::ACCESS GRANTED : accès autorisé
         * VoterInterface::ACCESS ABSTAIN : s'abstenir de voter sur le mécanisme
         */
        // get current logged in user
        //NB : le token est une clé avec un id d'utilisateur qui est en session
        $user = $token->getUser();

        //si l'utilisateur n'est pas connecté
        if($user instanceof UserInterface){
            return VoterInterface::ACCESS_DENIED;//Accès refusé
        }

        //Si le jeweler id est égal à l'id de l'utilisateur
        if(metho_exists($object,'getJeweler')){
            if($object->getJeweler()->getId() == $user->getId()){
                return VoterInterface::ACCESS_GRANTED; //Accès permis
            }
        }
        return VoterInterface::ACCESS_DENIED;
    }


} 