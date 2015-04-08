<?php

//l'endroit ou je déclare là où je mets le contrôileur

namespace Store\BackendBundle\Controller;

//inclure la classe controller de Symfony pour pouvoir hériter de cette classe

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ProductController
 * @package store\BackendBundle\Controller
 */
class ProductController extends Controller {

    public function listAction(){
        //récupère le manager de doctrine : le conteneur d'objets

        $em = $this->getDoctrine()->getManager();

        //je récupère tous les produits de ma badse de donnée avec la méthode FindAll()

        $products = $em->getRepository ('StoreBackendBundle:Product')->findAll();
        //nom du bundle, nom de l'entité


        return $this->render('StoreBackendBundle:Product:list.html.twig', array('products'=>$products
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #la page renvoie la vue d'un produit
    public function viewAction($id, $name){
        #j'envoie à la vue mon id avec array. le nom de la clé est le nom de la variable disponible en vue
        return $this->render('StoreBackendBundle:Product:view.html.twig',
            array( 'id' => $id,
                   'name' => $name
            )
        );
    }

}

