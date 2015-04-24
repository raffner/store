<?php
namespace Store\BackendBundle\Listener;

/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 24/04/15
 * Time: 10:50
 */
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;


/**
 * Class AuthentificationListener
 * @package Store\BackendBundle\Listener
 */
class AuthentificationListener {

    /*
     * @var EntityManager\null
     */
    protected $em;
    //Le constructeur de ma classe
    //Avec deux arguments : L'entité manager et le contexte de sécurité
    /**
     * @param EntityManager $em
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(EntityManager $em,SecurityContextInterface $securityContext)
    {
        //Je stocke dans deux attributs les services récupérés
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    /**
     * C'est la méthode qui est déclenchée après l'événement 'InteractiveLogin'
     * (action de Login ds la sécurité)
     * prend en argument l'événement
     * @param InteractiveLoginEvent $event
     */
    public function onAuthentificationSuccess(InteractiveLoginEvent $event){

        $now = new \DateTime('now');
        //Récupérer l'utilisateur courant connecté depuis le contexte de sécurité
        $user = $this->securityContext->getToken()->getUser();

        //met à jour la date de connexion de l'utilisateur et la passe à la date 'aujourd'hui'
        $user->setDateAuth($now);

        //Enregistre mon utilisateur en bdd avec sa date modifiée (via persist et flush)
        $this->em->persist($user);
        $this->em->flush();
    }
}