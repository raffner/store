<?php
namespace Store\BackendBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 27/04/15
 * Time: 10:22
 */



class JewelerControler extends Controller{


    /*
     * Méthode 2 pour restreindre l'accès au niveau de la méthode
     * @Security(has_role('ROLE_EDITOR'))
     */

    public function accountAction(){
        //récupère le manager de doctrine : le conteneur d'objets qui permet def aire des requetes côté objet
        //Méthode un : restreindre l'accès au niveau de ma méthode de contrôleur (renvoie un message d'erreur)
        //if(false === $this->get('security.context')->isGranted('ROLE_EDITOR')){
        //throw new AccessDeniedException("Accès interdit pour ce type de contenu");
        //}
        $em = $this->getDoctrine()->getManager();

        //récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        //nom du bundle, nom de l'entité : envoi en vue
        return $this->render('StoreBackendBundle:Jeweler:account.html.twig', array(
            'jeweler' => $user
        ));
    }



} 