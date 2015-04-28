<?php

//l'endroit ou je déclare là où je mets le contrôileur

namespace Store\BackendBundle\Controller;

//inclure la classe controller de Symfony pour pouvoir hériter de cette classe


use Store\BackendBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Store\BackendBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
//lié à la méthode 2 pour restreindre l'accès au contrôleur

/**
 * Class ProductController
 * @package store\BackendBundle\Controller
 */
class ProductController extends Controller {

    /*
     * Méthode 2 pour restreindre l'accès au niveau de la méthode
     * @Security(has_role('ROLE_EDITOR'))
     */

    public function listAction(){
        //récupère le manager de doctrine : le conteneur d'objets qui permet def aire des requetes côté objet
        //Méthode un : restreindre l'accès au niveau de ma méthode de contrôleur (renvoie un message d'erreur)
        //if(false === $this->get('security.context')->isGranted('ROLE_EDITOR')){
            //throw new AccessDeniedException("Accès interdit pour ce type de contenu");
        //}
        $em = $this->getDoctrine()->getManager();

        //récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        //je récupère tous les produits de jeweller numéro 1

        $products = $em->getRepository('StoreBackendBundle:Product')->getProductsByUser($user);

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
    public function activateAction(Product $id, $action){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();
        $id->setActive($action);
        $em->persist($id);
        $em->flush();
        //Je crée un message flash avec pour clé "success"
        $this->get('session')->getFlashBag()->add(
            'success',
        'Votre produit a bien été activé'
        );
        return $this->redirectToRoute('store_backend_product_list');


    }
    public function coverAction(Product $id, $action){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();
        $id->setCover($action);
        $em->persist($id);
        $em->flush();
        //Je crée un message flash avec pour clé "success"
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre produit a bien été mis en couverture'
        );
        return $this->redirectToRoute('store_backend_product_list');


    }
    /*
     * Je récupère l'objet request qui récupère toutes mes données en Get ou en post
     */
    public function newAction(Request $request){
        //Je crée une nouvelle entité product : NB : USER à chaque création d'objet
        $product=new Product();

        $user = $this->getUser();

        $product->setJeweler($user);//J'associe mon jeweller à un produit

        // J'initialise la quantité et le prix de mon produit
        //NB : initialiser tous les objets de product : à faire dans le constructeur Product.php
        //$product->setQuantity(0);
        //$product->setPrice(0); NB : l'objet étant intialisé au niveau du constructeur, je n'ai pas besoin des seteurs

        //Je crée un formulaire en associant avec mon produit
        $form = $this->createForm(new ProductType($user), $product,
                array(
                    'attr' => array(
                            'validation_groups'=> 'new',
                            'method' => 'post',
                            'novalidate' => 'novalidate',
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
            $em = $this->getDoctrine()->getManager();// je récupère le manager de doctrine uniquement à ce moment de connexion
            //et pas à la phase de chargment

            //Le fichier est ici uploadé en faisant appel à la méthode upload
            /** @var $product TYPE_NAME */
            $product->upload();
 +
            $em->persist($product);//J'enregistre mon objet ds doctrine (l'objet est en cache à cet instant, juste avant d'être flushé)
            $em->flush();//J'envoie ma requête d'insert à ma table product.
            // Je crée un message flash avec la clé sucess et un message de confirm
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre produit a bien été créé!'
            );

//            $quantity = $product->getQuantity();
//            //Utilisation du service de notification
//            if($quantity < 5){
//                $this->get('store.backend.notification')->notify($product->getId(),
//                    "La quantité de " .$product->getTitle(). "Votre stock est faible",
//                    "product",
//                    "warning"
//                );
//            }

            return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route vers la liste de mes produits.
        }

        return $this->render('StoreBackendBundle:Product:new.html.twig',
            array('form' =>$form->createView())
        );
    }
    /*
     * is_granted
     * 1er argument : atribut à vide
     * 2e argument : l'objet product est passé en arguement
     * @security("is_granted('', id)")
     */
    public function editAction(Request $request, Product $id){


        $em = $this->getDoctrine()->getManager();// je récupère le manager de doctrine

        //Je vais chercher un objet par son id (il ne s'agit pas en effet d'un nouveau produit mais d'un produit existant)
        $product = $em->getRepository('StoreBackendBundle:Product')->find($id)
;
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1);
        $product->setJeweler($jeweler);//J'associe mon jeweller à un produit


        //Je crée un formulaire en associant avec mon produit
        $form = $this->createForm(new ProductType(1), $product,
            array(
                'validation_groups'=> 'new',
                'attr' => array(
                    'method' => 'post',
                    'novalidate' => 'novalidate',
                    'action' => $this->generateUrl('store_backend_product_edit',
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
            $product->upload();

            $em = $this->getDoctrine()->getManager();// je récupère le manager de doctrine
            $em->persist($product);//J'enregistre mon objet ds doctrine (l'objet est en cache à cet instant, juste avant d'être flushé)
            $em->flush();//J'envoie ma requête d'insert à ma table product.
            //Utilisation du service de notification
//            if($product->getQuantity() < 5){
//                $quantity = $product->getQuantity();
//                //Utilisation du service de notification
//                    $this->get('store.backend.notification')->notify($product->getId(),
//                        "Votre produit " .$product->getTitle(). "est bientôt épuisé",
//                        "product",
//                        "danger"
//                    );
//
//            }


            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre produit a bien été modifié!'
            );
//            //je récupère la quantité du produit enregistré
//            $quantity = $product->getQuantity();
//            if($quantity == 1){
//                $this->get('store.backend.notification')->notify($product->getId(),
//                    "Attention " .$product->getTitle(). "il ne vous reste plus qu'un article",
//                    "product",
//                    "danger"
//                );
//
//
//
//                $this->get('session')->getFlashBag()->add(
//                    'warning',
//                    'Votre produit est unique!'
//                );
//            }

            return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route vers la liste de mes produits.
        }

        return $this->render('StoreBackendBundle:Product:edit.html.twig',
            array('form' =>$form->createView())
        );
    }


}

