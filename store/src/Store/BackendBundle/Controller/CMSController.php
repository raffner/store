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

            return $this->render('StoreBackendBundle:CMS:list.html.twig');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #la page renvoie la vue du CMS
    public function viewAction($id, $name){
        #j'envoie à la vue mon id avec array. le nom de la clé est le nom de la variable disponible en vue
        return $this->render('StoreBackendBundle:CMS:view.html.twig',
            array( 'id' => $id,
                   'name' => $name
            )
        );
    }

}

