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
class JewelerType extends AbstractType
{
    /**
     * Methode qui va consrtuire mon formulaire
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', null, array(
            'label' => '<i class="fa fa-plus"></i> Nom de la boutique',
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Nom / Marque du bijoutier',
                'pattern' => '[a-zA-Z0-9- ]{4,}'
            )
        ));

        $builder->add('type', 'choice', array(
            'label' => "Type de société",
            'choices'   => array(
                "1" => 'Autoentrepreneur',
                "2" => 'SAS',
                "3" => 'SARL',
                "4" => 'SARL',
                "5" => 'SA',
                "6" => 'EURL',
                "7" => "Association",
                "8" => "SNC",
                "9" => "SASU",
                "10" => "Autre",
            ),
            'required'  => true, // liste déroulante obligatoire
            'preferred_choices' => array("Autoentrepreneur"), // champs choisi par défault
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('meta',  new JewelerMetaType(), array(
            'cascade_validation' => true,
        ));

        $builder->add('file', 'file', array(
            'label' => '<i class="fa fa-picture-o"></i> Image de présentation',
            'required'  => false,
            'attr' => array(
                'class' => 'form-control',
                'accept' => 'image/*',
                'capture' => 'capture'
            )
        ));

        $builder->add('description', null, array(
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'rows' => 8,
                'placeholder' => 'Soignez une longue description complète de votre boutique',
            )
        ));

        $builder->add('email', 'email', array(
            'required'  => true,
            'label' => '<i class="fa fa-envelope"></i> Email',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Email pro/perso',
            )
        ));
        $builder->add('username', null, array(
            'required'  => true,
            'label' => "<i class='fa fa-user'></i> Pseudonyme",
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Login de 4 caractères minimum',
                'pattern' => '[a-zA-Z0-9- ]{4,}'
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


























