<?php
namespace Store\BackendBundle\Controller;

use Store\BackendBundle\Entity\Jeweler;
use Store\BackendBundle\Form\JewelerSubscribeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;



/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 20/04/15
 * Time: 12:34
 */
class SecurityController extends Controller{

        /**
         *
         * Page de login
         */


        public function loginAction(Request $request){
            $session = $request->getSession();
            //Get the login error if there is one
            /**
             * on interroge le mécanisme de sécurité de Symfony
             * qui vérifie le bon login et le bon mot de passe
             */
            if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)){
                $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);

            }
            else{
                $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
                $session->remove(SecurityContext::AUTHENTICATION_ERROR);
            }


            /*
             *
             * Je retourne la vue index de mon dossier Main
             */
            return $this->render('StoreBackendBundle:Security:login.html.twig', array(
                'last_username'=>$session->get(SecurityContext::LAST_USERNAME),
                'error' => $error,
            ));
        }

    /**
     * * Page de souscription pour les jeweler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subscribeAction(request $request)
    {
         // Je crée un nouiveau jeweler
        $jeweler = new Jeweler();

        //Je crée mon formulaire d'inscription au jeweler
        $form = $this->createForm(new JewelerSubscribeType(), $jeweler, array(
             'validation_groups' => 'subscribe',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' =>$this->generateUrl('store_backend_security_subscribe')

             )
        ));

        //Je lei le formulaire à la requête
        $form->handleRequest($request);

        if($form->isValid()){
        //Je récupère le champ de mon champ password
        //Après qu'il ait été hydraté par la méthode
        $password = $form['password']->getData();
        //Je récupère l'encodeur fixé par la couche sécurité de Symfony (sha516)
        $factory = $this->get('security.encoder_factory');

        //Je récupère l'encodeur de mon jeweller
        $encoder = $factory->getEncoder($jeweler);

        //J'encode mon mot de passe avec l'encodeur de sécurité et le salt
        $password = $encoder->encodePassword($password, $jeweler->getSalt()); // récupère le mot de pass

        //Modifier le mot de passe encodé de mon jeweler
        $jeweler->setPassword($password);

        $em = $this->getDoctrine()->getManager();//Je récupère le manager de Doctrine

        //Je récupère le rôle jeweller par l'entité (ROLE_JEWELER)
        $group = $em->getRepository('StoreBackendBundle:Groups')->find(1);

        //J'associe mon jeweller au rôle JEWELER
        $jeweler->addGroup($group);

        $em->persist($jeweler); //enregistrement
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre compte a bien été créé'

        );
        $this->get('session')->getFlashBag()->add(
            'info',
            'Vous pouvez vous identifier'
        );
        return $this->redirectToRoute('store_backend_security_login');//redirection selon la route
    }
        return $this->render('StoreBackendBundle:Security:subscribe.html.twig', array(
            "form" => $form->createView()
        ));
    }
}
