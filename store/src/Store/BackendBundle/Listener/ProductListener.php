<?php
namespace Store\BackendBundle\Listener;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Store\BackendBundle\Entity\Product;
use Store\BackendBundle\Notification\Notification;

/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 27/04/15
 * Time: 14:25
 */




class ProductListener {

    protected $notification;

    /**
     * @var
     */
    protected $em;

    /**
     * Constructeur qui reçoit en argument le service de notification
     * On récupère le manager de doctrine en second argument
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;

    }

    /**
     * Méthode qui sera appelée depuis mon services.yml
     * et reçoit en argument mon événement Doctrine
     * @param LifecycleEventArgs $
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        //Je récupère mon objet après modification (update)
        $entity = $args->getEntity();
        $em = $args->getEntityManager(); // récupérer l'entité manager
        //si mon objet est une instance de mon entité Product
        if ($entity instanceof Product){

            //récupérer le titre de mon produit
            $title = $entity->getTitle();

            # 2 tableaux avec accent
            $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
            $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
            $slug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$title)));

            //setSlug me permet de modifier le slug de mon produit
            //Persist et flush pour enregistrer en base de donnée
            $entity->setSlug($slug);
            //récupérer la date


            $em->persist($entity);
            $em->flush($entity);


            //Si la quantité de mon produit est égale à 1
            if($entity->getQuantity( )== 1){
                $this->notification->notify(
                    $entity->getId(),
                    'Attention, votre produit' .$entity->getTitle(). 'est bientôt en rupture de stock',
                    'product',
                    'danger'

                );
            }
           elseif($entity->getQuantity()<5){
               $this->notification->notify(
                   $entity->getId(),
                   'Attention, votre produit' .$entity->getTitle(). 'est bientôt en rupture de stock',
                   'product',
                   'warning'

               );
            }
         }

    }

    /**
     * Avant la modification de mon objet
     * @param LifecycleEvenArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args){

        //Je récupère mon objet avant la persistance de mon objet
        $entity = $args->getEntity();

        // Si mon objet est un objet de l'entité Product
        if ($entity instanceof Product){
        $now = new\DateTime('now');//Objet dateTime à aujourd'hui pour pouvoir récupérer la date
        $entity->setDateUpdated($now);// Modification de la dateUpdated
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args){

        /**
         * Appel de la méthode postUpdate dans la méthode persist (refactorisation)
         */
        $this->postUpdate($args);
    }
}

