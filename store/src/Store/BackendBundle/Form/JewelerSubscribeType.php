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
            'label' => 'Nom de la bijouterie', //label de mon chmpa
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Nom / Marque du bijoutier',
                'pattern' => '[a-zA-Z0-9- ]{5,}'
            )
        ));

        $builder->add('username', null, array(
            'label' => "Nom d'utilisateur", //label de mon chmpa
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Login choisi',
                'pattern' => '[a-zA-Z0-9- ]{5,}'
            )
        ));

        $builder->add('email', 'email', array(
            'label' => "Email d'utilisateur", //label de mon chmpa
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Votre email',
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
                                'class' => 'form-control',
                                'autocomplete' => 'off',
                                'placeholder' => 'Au moins 6 caractères',
                                'pattern' => '.{6,}')),
            'second_options' =>
            array('label' => 'Confirmation du mot de passe',
                'attr' => array('value' => '',
                                'class' => 'form-control',
                                'autocomplete'=> 'off',
                                'placeholder' => 'Retaper votre mot de passe',
                                'pattern' => '.{6,}'))
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
        return "store_backend_jeweler_subscribe";
    }

}


























