<?php

//l'endroit ou je déclare là où j e mets le contrôileur

namespace Store\BackendBundle\Controller;

//inclure la classe controller de Symfony pour pouvoir hériter de cette classe

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MainController
 * @package store\BackendBundle\Controller
 */
class MainController extends Controller {
    /**
     * Dashboard : la page d'accueil par défaut sur le backend : cette action renvoie une vue.
     */
    public function indexAction(){

        //Récupérer Doctrine Manager
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        //je récupère le nombre de produits de mon bijoutier
        //Je fais appel à mon repository ProductRepository
        //et à la fonction getCountByUser
        $nbprod = $em->getRepository('StoreBackendBundle:Product')->getCountByUser($user);

        $nbcat = $em->getRepository('StoreBackendBundle:Category')->getCountByUser($user);

        $nbcms = $em->getRepository('StoreBackendBundle:Cms')->getCountByUser($user);

        $nbcom = $em->getRepository('StoreBackendBundle:Comment')->getCountByUser($user);

        $nbsup = $em->getRepository('StoreBackendBundle:Supplier')->getCountByUser($user);

        $nbord = $em->getRepository('StoreBackendBundle:Orders')->getCountByUser($user);

        $nbsum = $em->getRepository('StoreBackendBundle:Orders')->getCountOrdersByUser($user);

        $nblast = $em->getRepository('StoreBackendBundle:Orders')->getLastOrdersByUser($user);

        $ctlast = $em->getRepository('StoreBackendBundle:Comment')->getLastCommentsByUser($user);

        $nbprod = $em->getRepository('StoreBackendBundle:Category')->getProductsInCategoriesByUser($user);








        //Je retourne la vue index de mon dossier Main
        return $this->render('StoreBackendBundle:Main:index.html.twig',
            array(
                    'nbprod' => $nbprod,
                    'nbcat'=> $nbcat,
                    'nbcms'=>$nbcms,
                    'nbcom'=>$nbcom,
                    'nbsup'=>$nbsup,
                    'nbord'=>$nbord,
                    'nbsum'=>$nbsum,
                    'nblast'=>$nblast,
                    'ctlast'=>$ctlast,




            )
        );
    }



}