<?php

//l'endroit ou je déclare là où je mets le contrôileur

namespace Store\BackendBundle\Controller;

//inclure la classe controller de Symfony pour pouvoir hériter de cette classe

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CategoryController
 * @package store\BackendBundle\Controller
 */
class CategoryController extends Controller {

    public function listAction(){

        return $this->render('StoreBackendBundle:Category:list.html.twig');
    }
    #la page renvoie la vue d'une catégorie
    public function viewAction($id, $name){

    #j'envoie à la vue mon id
        return $this->render('StoreBackendBundle:Category:view.html.twig',
            array(
            'id' => $id,
            'name' => $name)
        );
    }
}

