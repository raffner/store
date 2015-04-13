<?php

//l'endroit ou je déclare là où je mets le contrôleur

namespace Store\BackendBundle\Controller;

//inclure la classe controller de Symfony pour pouvoir hériter de cette classe

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ProductController
 * @package store\BackendBundle\Controller
 */
class CMSController extends Controller {

    public function listAction(){
        //récupère le manager de doctrine : le conteneur d'objets

        $em = $this->getDoctrine()->getManager();

        //je récupère tous les produits de ma badse de donnée avec la méthode FindAll()

        $pages = $em->getRepository ('StoreBackendBundle:Cms')->getCMSByUser(1);
        //nom du bundle, nom de l'entité
            return $this->render('StoreBackendBundle:CMS:list.html.twig',
                array(
                    'pages'=> $pages
                ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #la page renvoie la vue du CMS
    public function viewAction($id){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();

        //récupèrte le produit de ma base de données : nom du bundle : nom de l'entité
        $CMS = $em->getRepository('StoreBackendBundle:Cms')->find($id);

        //j'envoie à la vue mon id avec array. le nom de la clé est le nom de la variable disponible en vue
        return $this->render('StoreBackendBundle:CMS:view.html.twig',
            array(
                   'CMS' => $CMS
            )
        );
    }
    public function removeAction($id){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();

        //récupèrte le produit de ma base de données
        $CMS = $em->getRepository('StoreBackendBundle:Cms')->find($id);

        $em->remove($CMS);
        $em->flush;

        $this->redirectToRoute('store_backend_cms_list');


    }


}




