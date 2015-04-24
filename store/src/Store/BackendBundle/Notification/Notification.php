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
     * criticity : success-danger-warning-info
     */
    public function notify($message, $criticity = "success"){
        //La fonction set va me mettre en session le message que je passe en argument avec la clé 'alert'
        //On a ajouté un argument criticity : on va stocker dans un tableau associatif les variables
        $this->session->set('alert', array(
            'message' => $message,
            'criticity' => $criticity,
        ));


    }

} 