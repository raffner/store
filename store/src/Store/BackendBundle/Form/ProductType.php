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
class ProductType extends AbstractType{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * Méthode qui me permet de construire le formulaire
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * Via la méthode add : Ajoute un champ dans mon formulaire
         * les champs seront les noms des attributs de l'entité traitée (ici Product)
         * Le deuxième argument à ma fonction add est le type de mon champ
         * Le troisième argument permet de personnaliser le label
         */


        $builder->add('title', null, array(
            'label'=>'Nom de mon bijoux',
            'required' =>true,
            'attr' => array(
             'class' =>'form-control',
             'placeholder' => 'Mettre un nom',
             'pattern' => '[a-zAz0-9- ]{5}'

            )
        ));
        $builder->add('ref', null, array(
            'label'=>'Référence de mon produit',
            'required' =>true,
        'attr' => array(
            'class' =>'form-control',
            'placeholder' => 'AA-XX-B',
            'pattern' => '[A-Z]{4}-[0-9] {2}-[A-Z]{1}'

        )
    ));
        $builder->add('category', null, array('label'=>'Catégories associées',
        'attr' => array(
            'class' =>'form-control',
        )
    ));
        $builder->add('summary', null, array('label'=>'Résumé',
            'attr' => array(
        'class' =>'form-control',
        'placeholder' => 'Résumé du descriptif',

            )
    ));
        $builder->add('description', null, array(
            'label'=>'Descriptif',
            'required' =>true,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'description du bijoux',

            )
        ));
        $builder->add('price', 'money', array(
            'label'=>'Prix HT',
            'required' =>true,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'Prix en euros',

            )
        ));
        $builder->add('taxe', 'choice', array(
             'choices'=> array('5' => '5', '19.6' => '19.6', '20' => '20'),
             'required' =>true, //liste déroulante obligatoire
             'label' =>'Taxe appliquée',
             'attr' => array(
             '  class'=> 'form-control',
            )
        ));
        $builder->add('quantity', 'number', array(
            'required' =>true, //liste déroulante obligatoire
            'label' =>'Quantité du produit',
            'attr' => array(
                'class' =>'form-control',
                'pattern' => '[0-9] [1-4]'

            )
        ));

        $builder->add('active', null, array(
                'label' =>'Produit activé dans la boutique',
            )
        );
        $builder->add('cover', null, array(
                'label' =>'Produit mis en couverture  dans la boutique',
            )

    );
        $builder->add('cms', null, array(
        'label'=>'Pages associées au produit',
        'attr' => array(
            'class' =>'form-control',
        )

        ));

        $builder->add('supplier', null, array(
        'label'=>'Fournisseurs associées au produit',
        'attr' => array(
            'class' =>'form-control',
        )

    ));
        $builder->add('tag', null, array(
        'label'=>'Tags associées au produit',
        'attr' => array(
            'class' =>'form-control',
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
     * Lier le formulaire à une entité (product) sous condition qu'elle enregistre dans une table précise.
     * Mon formulaire enregistre en effet un produit dans la table product
     * Tous les champs vont respecter les attributs de l'entité product
     */

    public function setDefaultOptions (OptionsResolverInterface $resolver){
       /*
        * Je lie le formulaire à l'entité Product
        */
        $resolver->setDefaults(array(
            'data_class'=>'Store\BackendBundle\Entity\Product',

        ));
    }

    /**
     * GetName va me retourner un nom de formulaire
     * @return string
     */
    public function getName()
    {
        return "store_backend_product";
    }
}
