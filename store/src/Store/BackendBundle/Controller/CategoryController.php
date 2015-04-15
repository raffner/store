<?php

//l'endroit ou je déclare là où je mets le contrôileur

namespace Store\BackendBundle\Controller;

//inclure la classe controller de Symfony pour pouvoir hériter de cette classe

use Store\BackendBundle\Entity\Category;
use Store\BackendBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package store\BackendBundle\Controller
 */
class CategoryController extends Controller {

    public function listAction(){
        //récupère le manager de doctrine : le conteneur d'objets

        $em = $this->getDoctrine()->getManager();

        //je récupère tous les produits de ma badse de donnée avec la méthode FindAll()

        $categories = $em->getRepository ('StoreBackendBundle:Category')->getCategoriesByUser(1);

        //nom du bundle, nom de l'entité
        return $this->render('StoreBackendBundle:Category:list.html.twig',
            array('categories'=>$categories ));
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

    /*
         * Je récupère l'objet request qui récupère toutes mes données en Get ou en post
         */
    public function newAction(Request $request){
        //Je crée une nouvelle entité category : NB : USER à chaque création d'objet
        $category=new Category();
        $em = $this->getDoctrine()->getManager();// je récupère le manager de doctrine
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1);
        $category->setJeweler($jeweler);//J'associe mon jeweller à une catégorie

        // J'initialise les données de mes catégories
        //NB : initialiser tous les objets de catégorie : à faire dans le constructeur categorie.php
        //$category->setQuantity(0);
        //$category->setPrice(0); NB : l'objet étant intialisé au niveau du constructeur, je n'ai pas besoin des seteurs

        //Je crée un formulaire en associant avec ma catégorie
        $form = $this->createForm(new CategoryType(), $category,
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
