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

    public function listAction(Request $request){
        //récupère le manager de doctrine : le conteneur d'objets

        $em = $this->getDoctrine()->getManager();
        //récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        //je récupère tous les produits de ma badse de donnée avec la méthode FindAll()

        $pages = $em->getRepository ('StoreBackendBundle:Cms')->getCMSByUser($user);
        //Paginer mes produits :
        //Je récupère le bundle Paginator qui me sert à paginer
        $paginator  = $this->get('knp_paginator');
        // J'utilise la méthode paginate du service knp paginator
        $pagination = $paginator->paginate(
            $pages,//Je lui envoie ma collection de CMS
            $request->query->get('page', 1)/*page number*/,
            //Récupère le numéro de page sur lequel je me trouve. Par défaut, il prendra la page n° 1
            5/*Je limite à 5 mon résultat de sortie : 5 cms par pages*/
        );
        //nom du bundle, nom de l'entité
            return $this->render('StoreBackendBundle:CMS:list.html.twig',
                array(
                    'pages'=> $pagination
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

        //récupèrte le cms de ma base de données
        $CMS = $em->getRepository('StoreBackendBundle:Cms')->find($id);

        $em->remove($CMS);
        $em->flush();
       return $this->redirectToRoute('store_backend_cms_list');


    }
    public function activateAction(Cms $id, $action){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();
        $id->setActive($action);
        $em->persist($id);
        $em->flush();
        //Je crée un message flash avec pour clé "success"
        $this->get('session')->getFlashBag()->add(
            'success',
            //'Votre page a bien été modifiée'
            //j'ai remplacé mon message au niveau d el'activation de mes pages
            $this->get('translator')->trans('cms.flashdatas.activate', array(),'cms')
        );
        return $this->redirectToRoute('store_backend_cms_list');


    }
    public function stateAction(Cms $id, $action){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();
        $id->setState($action);
        $em->persist($id);
        $em->flush();
        //Je crée un message flash avec pour clé "success"
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre page a bien été modifiée'
        );
        return $this->redirectToRoute('store_backend_cms_list');


    }



    /*
     * Je récupère l'objet request qui récupère toutes mes données en Get ou en post
     */
    public function newAction(Request $request){
        //Je crée une nouvelle entité CMS : NB : USER à chaque création d'objet
        $CMS=new CMS();

        $user = $this->getUser();

        $CMS->setJeweler($user);//J'associe mon jeweller à un CMS



        // J'initialise les données de mes catégories
        //NB : initialiser tous les objets de cms : à faire dans le constructeur cms.php
        //$cms->setQuantity(0);
        //$cms->setPrice(0); NB : l'objet étant intialisé au niveau du constructeur, je n'ai pas besoin des seteurs

        //Je crée un formulaire en associant avec mon CMS
        $form = $this->createForm(new CmsType(), $CMS,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('store_backend_cms_new')
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
            $em->persist($CMS);//J'enregistre mon objet ds doctrine (l'objet est en cache à cet instant, juste avant d'être flushé)
            $em->flush();//J'envoie ma requête d'insert à ma table Cms.
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre CMS a bien été créé!'
            );
            return $this->redirectToRoute('store_backend_cms_list'); //redirection selon la route vers la liste de mes CMS.
        }

        return $this->render('StoreBackendBundle:CMS:new.html.twig',
            array('form' =>$form->createView())
        );
    }

    public function editAction(Request $request, $id){


        $em = $this->getDoctrine()->getManager();// je récupère le manager de doctrine

        //Je vais chercher un objet par son id (il ne s'agit pas en effet d'un nouveau produit mais d'un produit existant)
        $CMS = $em->getRepository('StoreBackendBundle:Cms')->find($id)
        ;
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1);
        $CMS->setJeweler($jeweler);//J'associe mon jeweller à un produit


        //Je crée un formulaire en associant avec mon produit
        $form = $this->createForm(new CmsType(1), $CMS,
            array(
                'validation_groups'=> 'new',
                'attr' => array(
                    'method' => 'post',
                    'novalidate' => 'novalidate',
                    'action' => $this->generateUrl('store_backend_cms_edit',
                            array('id' => $id))
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
            $em->persist($CMS);//J'enregistre mon objet ds doctrine (l'objet est en cache à cet instant, juste avant d'être flushé)
            $em->flush();//J'envoie ma requête d'insert à ma table product.
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre CMS a bien été modifié!'
            );
            return $this->redirectToRoute('store_backend_cms_list'); //redirection selon la route vers la liste de mes produits.
        }

        return $this->render('StoreBackendBundle:CMS:edit.html.twig',
            array('form' =>$form->createView())
        );
    }


}




