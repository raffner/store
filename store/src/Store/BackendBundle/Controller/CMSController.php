<?php

//l'endroit ou je déclare là où je mets le contrôleur

namespace Store\BackendBundle\Controller;

//inclure la classe controller de Symfony pour pouvoir hériter de cette classe

use Store\BackendBundle\Entity\Cms;
use Store\BackendBundle\Form\CmsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    /*
     * Je récupère l'objet request qui récupère toutes mes données en Get ou en post
     */
    public function newAction(Request $request){
        //Je crée une nouvelle entité CMS : NB : USER à chaque création d'objet
        $cms=new CMSController();
        $em = $this->getDoctrine()->getManager();// je récupère le manager de doctrine
        $jeweler = $em->getRepository('StoreBackendBundle:Cms')->find(1);
        $cms->setCms($cms);//J'associe mon jeweller à une catégorie

        // J'initialise les données de mes catégories
        //NB : initialiser tous les objets de catégorie : à faire dans le constructeur categorie.php
        //$category->setQuantity(0);
        //$category->setPrice(0); NB : l'objet étant intialisé au niveau du constructeur, je n'ai pas besoin des seteurs

        //Je crée un formulaire en associant avec ma catégorie
        $form = $this->createForm(new CmsType(), $cms,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('store_backend_category_new')
                    //L'action de formulaire pointe vers cette meme action de formulaire
                )
            ));
        //Je fusionne ma requête avec mon formulaire
        //Le formulaire étant lié à l'entité, il connait les contraintes de l'entité et les champs associés, mais maintenant il est aussi
        //lié à la requete (objet Request) qui est aussi chargé de données : La requete est lié au formulaire qui est lié à l'entité.
        //Les données saisie par l'utilisateur sont fusionnés par rapport au champ du formulaire qui sont aussi les attributs en entité.
        $form->handleRequest($request);
        //Si la totalité du formulaire est valide
        if($form->isValid()){

            $em = $this->getDoctrine()->getManager();// je récupère le manager de doctrine
            $em->persist($category);//J'enregistre mon objet ds doctrine (l'objet est en cache à cet instant, juste avant d'être flushé)
            $em->flush();//J'envoie ma requête d'insert à ma table product.

            return $this->redirectToRoute('store_backend_category_list'); //redirection selon la route vers la liste de mes catégories.
        }

        return $this->render('StoreBackendBundle:Category:new.html.twig',
            array('form' =>$form->createView())
        );
    }


}




