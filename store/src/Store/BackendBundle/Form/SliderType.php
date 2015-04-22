<?php

namespace Store\BackendBundle\Form;

/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 14/04/15
 * Time: 16:00
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Slider
 * @package Store\BackendBundle\Form
 */
class SliderType extends AbstractType{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * Méthode qui me permet de construire le formulaire
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * Via la méthode add : Ajoute un champ dans mon formulaire
         * les champs seront les noms des attributs de l'entité traitée (ici Slider)
         * Le deuxième argument à ma fonction add est le type de mon champ
         * Le troisième argument permet de personnaliser le label (attributs html "attr")
         */


        $builder->add('caption', null, array(
            'label'=>'Légende de mon slider',
            'required' =>true,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'Renseignez le champ légende'
            )
        ));

        $builder->add('file', 'file', array(
            'label'=>'Image',
            'required' =>false,
            'attr' => array(
                'class' =>'form-control',
                'accept' => 'image/*',
                'capture' => 'capture'
            )
        ));
        $builder->add('position', null, array(
            'label'=>'position de la catégorie',
            'required' =>true,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'position de la catégorie',

            )
        ));
        $builder->add('product', null, array(
            'label'=>'Produit associé',
            'required' =>true,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'Produit associé'
            )
        ));

        $builder->add('envoyer', 'submit', array(
                'attr' => array(
                    'class' =>'btn btn-primary',
                )

            )
        );
    }

    /**
     * Lier le formulaire à une entité (catégorie) sous condition qu'elle enregistre dans une table précise.
     * Mon formulaire enregistre en effet un produit dans la table catégorie
     * Tous les champs vont respecter les attributs de l'entité catégorie
     */

    public function setDefaultOptions (OptionsResolverInterface $resolver){
        /*
         * Je lie le formulaire à l'entité Slider
         */
        $resolver->setDefaults(array(
            'data_class'=>'Store\BackendBundle\Entity\Slider',

        ));
    }

    /**
     * GetName va me retourner un nom de formulaire :
     * @return string
     */
    public function getName()
    {
        return "store_backend_slider";
    }
}
