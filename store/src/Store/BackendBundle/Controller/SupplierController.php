<?php

//l'endroit ou je déclare là où je mets le contrôileur

namespace Store\BackendBundle\Controller;

//inclure la classe controller de Symfony pour pouvoir hériter de cette classe

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class SupplierController
 * @package store\BackendBundle\Controller
 */
class SupplierController extends Controller {

    public function listAction(){
        //récupère le manager de doctrine : le conteneur d'objets

        $em = $this->getDoctrine()->getManager();

        //je récupère tous les produits de ma badse de donnée avec la méthode FindAll()

        $suppliers = $em->getRepository ('StoreBackendBundle:Supplier')->getCommentsByUser(1);
        //nom du bundle, nom de l'entité
        return $this->render('StoreBackendBundle:Supplier:list.html.twig',
            array(
                'suppliers'=>$suppliers
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #la page renvoie la vue d'un produit
    public function viewAction($id, $name){
        #j'envoie à la vue mon id avec array. le nom de la clé est le nom de la variable disponible en vue
        return $this->render('StoreBackendBundle:Supplier:view.html.twig',
            array( 'id' => $id,
                'name' => $name
            )
        );
    }
    public function removeAction($id){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();

        //récupèrte le supplier de ma base de données
        $supplier = $em->getRepository('StoreBackendBundle:Supplier')->find($id);

        $em->remove($supplier);
        $em->flush();

        return $this->redirectToRoute('store_backend_supplier_list');


    }

}
