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
 * Formulaire de création de produits
 * Class ProductType
 * @package Store\BackendBundle\Form
 */
class CmsType extends AbstractType{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * Méthode qui me permet de construire le formulaire
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * Via la méthode add : Ajoute un champ dans mon formulaire
         * les champs seront les noms des attributs de l'entité traitée (ici CMS)
         * Le deuxième argument à ma fonction add est le type de mon champ
         * Le troisième argument permet de personnaliser le label (attributs html "attr")
         */


        $builder->add('title', null, array(
            'label'=>'cms.form.title',//label de mon champ
            'required' => false,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'cms.form.placeholder.title',
                'pattern' => '[a-zA-Z0-9- ]{5,}'

            )
        ));
        $builder->add('summary', null, array(
            'label'=>'cms.form.summary',
            'required' => false,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'cms.form.placeholder.summary',


            )
        ));

        $builder->add('description', null, array(
            'label'=>'cms.form.description',
            'required' => false,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'cms.form.placeholder.description',

            )
        ));
        $builder->add('image', null, array(
            'label'=>'cms.form.image',
            'required' => false,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'cms.form.placeholder.image',
            )

            ));

        $builder->add('video',null, array(
            'label'=>'Vidéo',
            'required' => false,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'Vidéo',

            )
        ));


        $builder->add('state',null, array(
            'required' =>false, //liste déroulante obligatoire
            'label' =>'Etat de la page',
            'attr' => array(
                'class' =>'form-control',
        )
        ));
        $builder->add('dateActive', null, array(

            'required' =>false, //liste déroulante obligatoire
            'widget' => 'choice',
            'label' =>'Date',

        ));


        $builder->add('envoyer', 'submit', array(
                'attr' => array(
                    'class' =>'btn btn-primary',
                )
            )
        );

    }

    /**
     * Lier le formulaire à une entité (product) sous condition qu'elle enregistre dans une table précise.
     * Mon formulaire enregistre en effet un produit dans la table product
     * Tous les champs vont respecter les attributs de l'entité product
     */

    public function setDefaultOptions (OptionsResolverInterface $resolver){
        /*
         * Je lie le formulaire à l'entité Product
         */
        $resolver->setDefaults([
            'data_class'=>'Store\BackendBundle\Entity\Cms',
            'translation_domain' => 'cms'

        ]);
    }

    /**
     * GetName va me retourner un nom de formulaire :
     * @return string
     */
    public function getName()
    {
        return "store_backend_cms";
    }
}
