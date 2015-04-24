<?php

//l'endroit ou je déclare là où je mets le contrôleur

namespace Store\BackendBundle\Controller;

//inclure la classe controller de Symfony pour pouvoir hériter de cette classe

use Store\BackendBundle\Entity\Slider;
use Store\BackendBundle\Form\SliderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProductController
 * @package store\BackendBundle\Controller
 */
class SliderController extends Controller {

    public function listAction(){
        //récupère le manager de doctrine : le conteneur d'objets

        $em = $this->getDoctrine()->getManager();
        //récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        //je récupère tous les produits de ma base de donnée avec la méthode FindAll()

        $sliders = $em->getRepository ('StoreBackendBundle:Slider')->getSlidersByUser($user);
        //nom du bundle, nom de l'entité
        return $this->render('StoreBackendBundle:Slider:list.html.twig',
            array(
                'sliders'=> $sliders
            ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #la page renvoie la vue du slider
    public function viewAction($id){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();

        //récupère le slider de ma base de données : nom du bundle : nom de l'entité
        $slider = $em->getRepository('StoreBackendBundle:Slider')->find($id);

        //j'envoie à la vue mon id avec array. le nom de la clé est le nom de la variable disponible en vue
        return $this->render('StoreBackendBundle:Slider:view.html.twig',
            array(
                'slider' => $slider
            )
        );
    }
    public function removeAction($id){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();

        //récupèrte le slider de ma base de données
        $slider = $em->getRepository('StoreBackendBundle:Slider')->find($id);

        $em->remove($slider);
        $em->flush();
        return $this->redirectToRoute('store_backend_slider_list');


    }
    public function activateAction(Slider $id, $action){
        // récupère le manager de la doctrine
        $em = $this->getDoctrine()->getManager();
        $id->setActive($action);
        $em->persist($id);
        $em->flush();
        //Je crée un message flash avec pour clé "success"
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre slider a bien été modifié'
        );
        return $this->redirectToRoute('store_backend_slider_list');


    }






    /*
     * Je récupère l'objet request qui récupère toutes mes données en Get ou en post
     */
    public function newAction(Request $request){
        //Je crée une nouvelle entité slider : NB : USER à chaque création d'objet
        $slider=new Slider();

        $user = $this->getUser();


        // J'initialise les données de mes slider
        //NB : initialiser tous les objets slider : à faire dans le constructeur Slider.php
        //$slider->setQuantity(0);
        //$slider->setPrice(0); NB : l'objet étant intialisé au niveau du constructeur, je n'ai pas besoin des seteurs

        //Je crée un formulaire en associant avec mon slider
        $form = $this->createForm(new SliderType(), $slider,
            array(
                'validation_groups'=> 'new',
                'attr' => array(
                    'method' => 'post',
                    'novalidate' => 'novalidate',
                    'action' => $this->generateUrl('store_backend_slider_new')
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
            $slider->upload();
            $em = $this->getDoctrine()->getManager();// je récupère le manager de doctrine
            $em->persist($slider);//J'enregistre mon objet ds doctrine (l'objet est en cache à cet instant, juste avant d'être flushé)
            $em->flush();//J'envoie ma requête d'insert à ma table slider
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre slider a bien été créé!'
            );
            return $this->redirectToRoute('store_backend_slider_list'); //redirection selon la route vers la liste de mes slider.
        }

        return $this->render('StoreBackendBundle:Slider:new.html.twig',
            array('form' =>$form->createView(), 'slider' => $slider)
        );
    }

    public function editAction(Request $request, $id){


        $em = $this->getDoctrine()->getManager();// je récupère le manager de doctrine

        //Je vais chercher un objet par son id (il ne s'agit pas en effet d'un nouveau produit mais d'un slider existant)
        $slider= $em->getRepository('StoreBackendBundle:Slider')->find($id)
        ;


        //Je crée un formulaire en associant avec mon slider
        $form = $this->createForm(new SliderType(1), $slider,
            array(
                'validation_groups'=> 'edit',
                'attr' => array(
                    'method' => 'post',
                    'novalidate' => 'novalidate',
                    'action' => $this->generateUrl('store_backend_slider_edit',
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
            $em->persist($slider);//J'enregistre mon objet ds doctrine (l'objet est en cache à cet instant, juste avant d'être flushé)
            $em->flush();//J'envoie ma requête d'insert à ma table product.
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre slider a bien été modifié!'
            );
            return $this->redirectToRoute('store_backend_slider_list'); //redirection selon la route vers la liste de mes produits.
        }

        return $this->render('StoreBackendBundle:Slider:edit.html.twig',
            array(
                'form' =>$form->createView(),
                'slider'=>$slider,
            )
        );
    }


}




