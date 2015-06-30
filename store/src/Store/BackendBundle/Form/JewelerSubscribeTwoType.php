<?php

namespace Store\BackendBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class JewelerSubscribeTwoType
 * @package Store\BackendBundle\Form
 */
class JewelerSubscribeTwoType extends AbstractType
{
    /**
     * Methode qui va consrtuire mon formulaire
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder->add('meta',  new JewelerMetaLightType(), array(
            'cascade_validation' => true,
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

        $builder->add('file', 'file', array(
            'label' => '<i class="fa fa-picture-o"></i> Image de présentation',
            'required'  => false,
            'attr' => array(
                'class' => 'form-control',
                'accept' => 'image/*',
                'capture' => 'capture'
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


























