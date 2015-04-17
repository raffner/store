<?php

//l'endroit ou je déclare là où j emets le contrôileur

namespace Store\BackendBundle\Controller;

//inclure la classe controller de Symfony pour pouvoir hériter de cette classe

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MainController
 * @package store\BackendBundle\Controller
 */
class StaticsController extends Controller {
    /**
     * page contact
     */
    public function contactAction(){
        /**
         * je retourne la vue contact contenue dans le dossier statics de mon bundle
         */
        return $this->render('StoreBackendBundle:Statics:contact.html.twig');
    }
    public function aboutAction(){
        #je retourne la vue about contenue dans le dossier statics de mon bundle
        return $this->render('StoreBackendBundle:Statics:about.html.twig');
    }
    public function termsAction(){
        #je retourne la vue mentions legales contenue dans le dossier statics de mon bundle
        return $this->render('StoreBackendBundle:Statics:terms.html.twig');
    }
    public function conceptAction(){
        #je retourne la vue concept contenue dans le dossier statics de mon bundle
        return $this->render('StoreBackendBundle:Statics:concept.html.twig');
    }

}