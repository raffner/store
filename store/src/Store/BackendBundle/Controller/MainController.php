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
       // $email = $this->get('store.backend.email');//Accède au conteneur de services
        //$email->send(); //et récupère le service store.backend.email et exécute la méthode que l'on a créée pour envoyer un email

          //La méthode Notify sera exécutée avec un message de bienvenue
        $this->get('store.backend.notification')->notify('Bienvenu sur la plateforme');


        $user = $this->getUser();

        //Récupérer Doctrine Manager

        $em = $this->getDoctrine()->getManager();



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



        $statOrder[] = $em->getRepository('StoreBackendBundle:Orders')->getOrderGraphByUser($user, new \DateTime('now'));
        $statOrder[] = $em->getRepository('StoreBackendBundle:Orders')->getOrderGraphByUser($user, new \DateTime('-1 month'));
        $statOrder[] = $em->getRepository('StoreBackendBundle:Orders')->getOrderGraphByUser($user, new \DateTime('-2 month'));
        $statOrder[] = $em->getRepository('StoreBackendBundle:Orders')->getOrderGraphByUser($user, new \DateTime('-3 month'));
        $statOrder[] = $em->getRepository('StoreBackendBundle:Orders')->getOrderGraphByUser($user, new \DateTime('-4 month'));
        $statOrder[] = $em->getRepository('StoreBackendBundle:Orders')->getOrderGraphByUser($user, new \DateTime('-5 month'));





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
                    'statOrder'=>$statOrder




            )
        );
    }



}