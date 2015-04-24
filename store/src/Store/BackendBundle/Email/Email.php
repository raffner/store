<?php
namespace Store\BackendBundle\Email;
/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 24/04/15
 * Time: 14:32
 */


/**
 * Création d'une classe Email pour pouvoir envoyer des emails personnalisés (service)
 * Class Email
 * @package Store\BackendBundle\Email
 */
class Email {

    /**
     * @var \Swift_Mailer Swift Mailer
     */
    protected $mailer;

    /**
     * @var \Twig_Environment Twig Template Engine
     */
    protected $twig;

    /**
     * Constructeur de ma class Email
     * A besoin du service swiftmailer et du service Twig
     * En argument, je récupère Swift Mailer
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig){

        $this->mailer = $mailer; //Je stocke
        $this->twig = $twig;

    }

    /**
     * Fonction qui envoie un email à un utilisateur
     */
    public function send(){

        //Je crée un message d'email en utilisant swift mailer de Symfony
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')// Le message
            ->setFrom('raffner@gmail.com')//L'expéditeur
            ->setTo('raffner@gmail.com')//Le destinataire
            ->setContentType('text/html')//Le mail est ainsi au format html
            ->setBody(
                $this->twig->render('StoreBackendBundle:Email:email.html.twig')// Le corps du mail qui sera une vue en Twig avec la fonction render
            );
        $this->mailer->send($message);
        //utilise le service mailer et envoie mon email avec la méthode send()

    }

} 