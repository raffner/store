<?php

//l'endroit ou je déclare là où je mets le contrôileur

namespace Store\BackendBundle\Controller;

//inclure la classe controller de Symfony pour pouvoir hériter de cette classe


use Store\BackendBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Store\BackendBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProductController
 * @package store\BackendBundle\Controller
 */
class ProductController extends Controller {

    public function listAction(){
        //récupère le manager de doctrine : le conteneur d'objets qui permet def aire des requetes côté objet

        $em = $this->getDoctrine()->getManager();

        //je récupère tous les produits de jeweller numéro 1

        $products = $em->getRepository('StoreBackendBundle:Product')->getProductsByUser(1);

        //nom du bundle, nom de l'entité : envoi en vue
        return $this->render('StoreBackendBundle:Product:list.html.twig', array('products'=>$products
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
   //la page renvoie la vue d'un produit
    public function viewAction($id, $name){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();

        //récupète le produit de ma base de données
        $product = $em->getRepository('StoreBackendBundle:Product')->find($id);

        //j'envoie à la vue mon id avec array. le nom de la clé est le nom de la variable disponible en vue
        return $this->render('StoreBackendBundle:Product:view.html.twig',
            array(
                   'product' => $product

            )
        );
    }

    /**
     * Action de suppression
     * @param $id
     */
    public function removeAction($id){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();

        //récupèrte le produit de ma base de données
        $product = $em->getRepository('StoreBackendBundle:Product')->find($id);

        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('store_backend_product_list');


    }
    /*
     * Je récupère l'objet request qui récupère toutes mes données en Get ou en post
     */
    public function newAction(Request $request){
        //Je crée une nouvelle entité product : NB : USER à chaque création d'objet
        $product=new Product();
        $em = $this->getDoctrine()->getManager();// je récupère le manager de doctrine
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1);
        $product->setJeweler($jeweler);//J'associe mon jeweller à un produit

        // J'initialise la quantité et le prix de mon produit
        //NB : initialiser tous les objets de product : à faire dans le constructeur Product.php
        //$product->setQuantity(0);
        //$product->setPrice(0); NB : l'objet étant intialisé au niveau du constructeur, je n'ai pas besoin des seteurs

        //Je crée un formulaire en associant avec mon produit
        $form = $this->createForm(new ProductType(), $product,
                array(
                    'attr' => array(
                            'method' => 'post',
                            'action' => $this->generateUrl('store_backend_product_new')
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
            $em->persist($product);//J'enregistre mon objet ds doctrine (l'objet est en cache à cet instant, juste avant d'être flushé)
            $em->flush();//J'envoie ma requête d'insert à ma table product.

            return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route vers la liste de mes produits.
        }

        return $this->render('StoreBackendBundle:Product:new.html.twig',
            array('form' =>$form->createView())
        );
    }
}

