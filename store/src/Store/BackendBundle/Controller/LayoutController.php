<?php
namespace Store\BackendBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 28/04/15
 * Time: 10:58
 */


/**
 * Class LayoutController
 * Ce contrôleur spécial contiendra mona ction rendue par Twig
 * @package Store\BackendBundle\Controller
 */
class LayoutController extends Controller {

    /**
     * Me retourne la liste de mes messages
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mymessagesAction(){

        //Je récupère l'entité Manager
        $em = $this->getDoctrine()->getManager();

        //Je récupère l'utilisateur connecté
        $user = $this->getUser();

        //Je récupère les messages depuis la requête
        $messages = $em->getRepository('StoreBackendBundle:Message')
            ->getLastMessagesByUser($user, 15);

        return $this->render('StoreBackendBundle:Partial:mymessages.html.twig'
            , array(
            'messages' => $messages

    ));
    }
        public function myordersAction(){

            //Je récupère l'entité Manager
            $em = $this->getDoctrine()->getManager();

            //Je récupère l'utilisateur connecté
            $user = $this->getUser();

            //Je récupère les messages depuis la requête
            $orders = $em->getRepository('StoreBackendBundle:Orders')
                ->getLastOrdersByUser($user, 15);

            return $this->render('StoreBackendBundle:Partial:myorders.html.twig'
                , array(
                    'orders' => $orders

                ));
        }
}









