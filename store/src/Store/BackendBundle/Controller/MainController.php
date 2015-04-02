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
       return $this->render('StoreBackendBundle:Main:index.html.twig');
    }

}