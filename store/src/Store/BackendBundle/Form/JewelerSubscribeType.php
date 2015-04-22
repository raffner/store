<?php

namespace Store\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Formulaire
 * Class ProductType
 * @package Store\BackendBundle\Form
 */
class JewelerSubscribeType extends AbstractType {

    /**
     * Méthode qui va construire mon formulaire
     * @param FormBuilderInterface $builder
     * @param array $option
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('title', null, array(
            'label'=>'Nom de la bijouterie',
            'required' => true,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'Nom / marque du bijoutier',
                'pattern' => '[a-zA-Z0-9- ]{5,}'

            )
        ));
        $builder->add('username', null, array(
            'label'=>"Nom d'utilisateur",
            'required' =>true,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'login choisi',
                'pattern' => '[a-zA-Z0-9- ]{5,}'

            )
         ));
        $builder->add('email', 'email', array(
            'label'=>"Email d'utilisateur",
            'required' =>true,
            'attr' => array(
                'class' =>'form-control',
                'placeholder' => 'Votre email choisi'


            )
         ));
         $builder->add('password', 'repeated', array(

            'required' =>true,
            'attr' => array(
                'autocomplete', 'off'),
            'type' => 'password',
            'first_name' => 'mdp',
            'second_name' => 'mdp_conf',
            'invalid_message' => "Le mot de pass n'est pas le même",
            'first_options' =>
                array('label' => 'mot de passe',
                    'attr' => array('value'=> '',
                    'autocomplete' => 'off',
                    'placeholder' => 'Au moins six caractères',
                    'pattern' =>'.{6,}'
                    )),

             'second_options' =>
                 array('label' => 'Confirmation de mot de passe'
                 ,
                     'attr' => array('value'=> '',
                         'autocomplete' => 'off',
                         'placeholder' => 'Retapez votre mot de passe',
                         'pattern' =>'.{6,}'
                     ))
         ));

        $builder->add('envoyer', 'submit', array(
                'attr' => array(
                    'class' =>'btn btn-primary',
                )

         ));
    }

    public function setDefaultOptions (OptionsResolverInterface $resolver)
    {
        /*
         * Je lie le formulaire à l'entité Product
         */
        $resolver->setDefaults(array(
            'data_class'=>'Store\BackendBundle\Entity\jeweler',

        ));
    }


    /**
     * GetName va me retourner un nom de formulaire :
     * @return string
     */
    public function getName()
    {
        return "store_backend_jeweler_subscribe";
    }

    }
