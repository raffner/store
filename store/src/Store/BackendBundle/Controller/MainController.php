<?php

//l'endroit ou je déclare là où j emets le contrôileur

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

        //je récupère le nombre de produits de mon bijoutier
        //Je fais appel à mon repository ProductRepository
        //et à la fonction getCountByUser
        $nbprod = $em->getRepository('StoreBackendBundle:Product')->getCountByUser(1);

        $nbcat = $em->getRepository('StoreBackendBundle:Category')->getCountByUser(1);

        $nbcms = $em->getRepository('StoreBackendBundle:Cms')->getCountByUser(1);

        $nbcom = $em->getRepository('StoreBackendBundle:Comment')->getCountByUser(1);

        $nbsup = $em->getRepository('StoreBackendBundle:Supplier')->getCountByUser(1);

        $nbord = $em->getRepository('StoreBackendBundle:Orders')->getCountByUser(1);

        $nbsum = $em->getRepository('StoreBackendBundle:Orders')->getCountOrdersByUser(1);

        $nblast = $em->getRepository('StoreBackendBundle:Orders')->getLastOrdersByUser(1);

        $ctlast = $em->getRepository('StoreBackendBundle:Orders')->getLastCountByUser(1);





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
                    'ctlast'=>$ctlast



            )
        );
    }



}