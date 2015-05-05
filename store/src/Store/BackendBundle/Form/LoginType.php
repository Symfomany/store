<?php

namespace Store\BackendBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class LoginType
 * @package Store\BackendBundle\Form
 */
class LoginType extends AbstractType
{
    /**
     * Methode qui va consrtuire mon formulaire
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('_username', null, array(
            'required'  => true,
            'attr' => array(
                'class' => 'form-control input-lg',
                'placeholder' => 'Login ou Email',
                'pattern' => '.{3,}',
                'autocomplete' => "off",
            )
        ));

        $builder->add('_password', 'password', array(
            'required'  => true,
            'attr' => array(
                'class' => 'form-control input-lg',
                'rows' => 8,
                'autocomplete' => "off",
                'placeholder' => '*******',
                'pattern' => '.{3,}'
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
        ));
    }
    /**
     * Methode déprécié pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
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


























