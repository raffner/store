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
        //récupère le manager de doctrine : le conteneur d'objets

        $em = $this->getDoctrine()->getManager();

        //je récupère tous les produits de ma badse de donnée avec la méthode FindAll()

        $categories = $em->getRepository ('StoreBackendBundle:Product')->findAll();
        //nom du bundle, nom de l'entité
        return $this->render('StoreBackendBundle:Category:list.html.twig', array('categories'=>$categories
        ));
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





