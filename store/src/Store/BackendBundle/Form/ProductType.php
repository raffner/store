<?php

namespace Store\BackendBundle\Form;

/**
 * Created by PhpStorm.
 * User: wac23
 * Date: 14/04/15
 * Time: 16:00
 */

use Store\BackendBundle\Repository\CategoryRepository;
use Store\BackendBundle\Repository\CmsRepository;
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
     * @var
     */
    protected $user;

    /**
     * @param null $user
     */
    public function __construct($user = null){
        $this->user = $user;
    }

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
         * Le troisième argument permet de personnaliser le label (attributs html "attr")
         */


        $builder->add('title', null, array(
            'label'=>'Nom de mon bijoux',
            'required' =>true,
            'attr' => array(
             'class' =>'form-control',
             'placeholder' => 'Mettre un nom',
             'pattern' => '[a-zA-Z0-9- ]{5,}'

            )
        ));
        $builder->add('ref', null, array(
            'label'=>'Référence de mon produit',
            'required' =>true,
        'attr' => array(
            'class' =>'form-control',
            'placeholder' => 'AA-XX-B',
            'pattern' => '[A-Z]{4}-[0-9]{2}-[A-Z]{1}'

        )
     ));
        /**
         * Méthode 1
         */
//        $builder->add('category', null, array(
//            'label'=>'Catégorie',
//            'class' => 'StoreBackendBundle:Category',
//            'property' => 'title',
//            'query_builder' => function(EntityRepository $er){
//                        return $er->createQueryBuilder('c')
//                            ->where('c.jeweler = :user')
//                            ->orderBy('c.title', 'ASC')
//                            ->setParameter('user', $this->$user);
//                },
//    ));
        /**
         * méthode 2
         */
        $builder->add('category', 'entity', array(
            'label'=>'Catégorie',
            'attr' => array(
                'class' =>'form-control',
             ),
            'class' => 'StoreBackendBundle:Category',
            'property' => 'title',
            'multiple' => true,//choix multiple
            'expanded' => true,//checbox plutôt quer liste déroulante : NB pour expanded, il faut avoir multiple
            'query_builder' => function(CategoryRepository $er){
                    return $er->getCategoryByUserBuilder($this->user);

                },
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
        $builder->add('composition', null, array(
            'label'=>'Composition du bijoux',
            'required' =>true,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'composition du bijoux',

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
        $builder->add('dateActive', 'datetime', array(
            'widget' =>'choice', //liste déroulante obligatoire
            'label' =>'Date active',
            'pattern' => '{{ day }}-{{ month }}-{{ year }}',

            )
        );
        $builder->add('quantity', 'number', array(
            'required' =>true, //liste déroulante obligatoire
            'label' =>'Quantité du produit',
            'attr' => array(
                'class' =>'form-control',
                'pattern' => '[0-9]{1,4}'

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

        $builder->add('cms', 'entity', array(
            'label'=>'Pages associées au produit',
            'attr' => array(
                'class' =>'form-control',
            ),
            'class' => 'StoreBackendBundle:Cms',
            'property' => 'title',
            'multiple' => true,//choix multiple
            'expanded' => true,//checbox plutôt quer liste déroulante : NB pour expanded, il faut avoir multiple
            'query_builder' => function(CmsRepository $er){
                    return $er->getCmsByUserBuilder($this->user);

                },
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
     * GetName va me retourner un nom de formulaire :
     * @return string
     */
    public function getName()
    {
        return "store_backend_product";
    }
}
