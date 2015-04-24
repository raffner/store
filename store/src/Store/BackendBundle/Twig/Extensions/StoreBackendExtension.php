<?php
namespace Store\BackendBundle\Twig\Extensions;
/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 23/04/15
 * Time: 18:08
 */




class StoreBackendExtension extends \Twig_Extension{

    /**
     * Fonction qui me retourne tous les filtres créés
     * @return array
     */
    public function getFilters()
      {
          //Retourne un tableau des filtres créés
          return array
          (
               //Twig_SimpleFilter :
              //-Le 1er argument est le nom du filtre en twig
              //-Le 2e arguement est le nom de la fonction que je vais créer
              new \Twig_SimpleFilter('state', array($this, 'state')),
          );
      }

    /**
     * @param $state
     * @return string
     */
    public function state($state)
        {
          if($state == 2){
              $badge = "<span class='label label-success'>Actif</span>";

          }elseif($state == 1){
              $badge = "<span class='label label-info'>En cours</span>";
          }
           else{
              $badge = "<span class='label label-warning'>Annulé</span>";
           }
           return $badge;
        }


    public function getName()
    {
        return 'store_backend_extension';
    }
} 