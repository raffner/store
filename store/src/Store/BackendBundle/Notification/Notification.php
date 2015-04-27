<?php
namespace Store\BackendBundle\Notification;
use Symfony\Component\HttpFoundation\Session\Session;
/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 24/04/15
 * Time: 17:06
 */



/*
 * Mon service de notification
 */
class Notification {
    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * Constructeur qui recevra mon service session
     */
    public function __construct(Session $session){

        $this->session = $session;

    }

    /**
     * Méthode qui va notifier une action : on a besoin du mécanisme des actions
     * On veut stocker
     * Arguments : $id : qui sera l'id de mon objet
     * $message : qui sera le message de notre notification
     * $nature : la nature de notre modification : success-danger-warning-info
     */
    public function notify($id, $message, $nature = "product", $criticity = "success"){
        // 1. A l'aide de la fonction get, nous récupérons dans une variable $tabsession
        //Le tableau de notifications par sa nature
        //$this->session->get(nature) : permet de récupérer un info par sa clé
        //Le 2e argument à la fonction Get permet d'initialiser un tableau vide si ma clé en session n'existe pas.
        $tabsession = $this->session->get($nature, array());

        // 2. Nous stockons dans ce tableau la notif avec un message, une criticité et une date
        $tabsession[$id] = array(
            'message' => $message,
            'criticity' => $criticity,
            'date' => new \DateTime("now"),
        );

        // Nous enregistrons le tableau des notifications en session
        $this->session->set($nature,$tabsession);

    }

} 