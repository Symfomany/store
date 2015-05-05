<?php

namespace Store\BackendBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class JewelerSubscribeType
 * @package Store\BackendBundle\Form
 */
class JewelerSubscribeType extends AbstractType
{
    /**
     * Methode qui va consrtuire mon formulaire
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', null, array(
            'required'  => true,
            'attr' => array(
                'class' => 'form-control input-lg',
                'placeholder' => 'Nom / Marque du bijoutier',
                'pattern' => '[a-zA-Z0-9- ]{4,}'
            )
        ));

        $builder->add('username', null, array(
            'required'  => true,
            'attr' => array(
                'class' => 'form-control input-lg',
                'placeholder' => 'Login de 4 caractères minimum',
                'pattern' => '[a-zA-Z0-9- ]{4,}'
            )
        ));

        $builder->add('description', null, array(
            'required'  => true,
            'attr' => array(
                'class' => 'form-control input-lg',
                'rows' => 8,
                'placeholder' => 'Soignez une longue description complète de votre boutique',
            )
        ));

        $builder->add('email', 'email', array(
            'required'  => true,
            'attr' => array(
                'class' => 'form-control input-lg',
                'placeholder' => 'Email pro/perso',
            )
        ));

        $builder->add('password', 'repeated', array(
            'required' => true,
            'type' => 'password',
            'first_name' => 'mdp',
            'second_name' => 'mdp_conf',
            'invalid_message' => "Le mot de passe n'est pas le même",
            'first_options' =>
            array('label' => 'Mot de passe',
                'attr' => array('value' => '',
                                'class' => 'form-control input-lg',
                                'autocomplete' => 'off',
                                'placeholder' => 'Au moins 6 caractères',
                                'pattern' => '.{6,}')),
            'second_options' =>
            array('label' => 'Confirmation du mot de passe',
                'attr' => array('value' => '',
                                'class' => 'form-control input-lg',
                                'autocomplete'=> 'off',
                                'placeholder' => 'Retaper votre mot de passe',
                                'pattern' => '.{6,}'))
        ));


        $builder->add('captcha', 'captcha', array(
                'background_color' => array(255,255,255),
                'width' => 300,
                'height' => 70,
                'attr' => array(
                'placeholder' => 'Saisissez le code de sécurité en image',
                'pattern' => '.{5,}',
                'class' => 'form-control input-lg',
                'length' => 6
            )
        )); // That's all !


        $builder->add('signup_confirm', 'checkbox', array(
            'required' => true,
            'mapped' => false,
            'attr' => array(
            )
        ));

        $builder->add('envoyer', 'submit', array(
            'attr' => array(
                'class' => 'btn btn-primary btn-sm'
            )
        ));




    }

    /**
     * Cette methode me permet de lié mon formulaire à moin entité Product
     * CAR mon formulaire enregistre un produit dans la table product
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // je lis le formulaire à l'entité Product
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\Jeweler',
        ));
    }
    /**
     * Methode déprécié pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\Jeweler',
        ));
    }
    /**
     * Nom du formulaire
     * @return string|void
     */
    public function getName()
    {
        return "";
    }

}


























