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

        $categories = $em->getRepository ('StoreBackendBundle:Category')->findAll();
        //nom du bundle, nom de l'entité
        return $this->render('StoreBackendBundle:Category:list.html.twig', array('categories'=>$categories
        ));
    }
    #la page renvoie la vue d'une catégorie
    public function viewAction($id, $name){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();

        //récupère le produit de ma base de données
        $category = $em->getRepository('StoreBackendBundle:Category')->find($id);

    #j'envoie à la vue mon id
        return $this->render('StoreBackendBundle:Category:view.html.twig',
            array(
            'category' => $category)
        );
    }

    public function removeAction($id){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();

        //récupèrte le produit de ma base de données
        $category = $em->getRepository('StoreBackendBundle:Category')->find($id);

        $em->remove($category);
        $em->flush;

        $this->redirectToRoute('store_backend_category_list');


    }




}
