<?php

namespace Store\BackendBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class JewelerMetaType
 * @package Store\BackendBundle\Form
 */
class JewelerMetaType extends AbstractType
{
    /**
     * Methode qui va consrtuire mon formulaire
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address', null, array(
            'required'  => true,
            'label' => "<i class='fa fa-map-marker'></i> Adresse",
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => '14 Rue Mandar',
            )
        ));
        $builder->add('zipcode', null, array(
            'required'  => true,
            'label' => "<i class='fa fa-map-marker'></i> CP",
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => '75002',
            )
        ));
        $builder->add('city', null, array(
            'required'  => true,
            'label' => "<i class='fa fa-map-marker'></i> Ville",
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Paris',
            )
        ));
        $builder->add('phone', null, array(
            'required'  => true,
            'label' => "<i class='fa fa-phone'></i> Téléphone",
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'XX-XX-XX-XX-XX',
            )
        ));
        $builder->add('website', null, array(
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'http://',
            )
        ));

        $builder->add('retour', "textarea", array(
            'required'  => true,
            'label' => '<i class="fa fa-retweet"></i> Retour de produit',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Retour et Expédition',
            )
        ));
        $builder->add('propos', "textarea", array(
            'required'  => true,
            'label' => '<i class="fa fa-home"></i> A propos de votre entreprise',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'A propos de votre société',
            )
        ));
        $builder->add('dawanda', 'url', array(
            'label' => '<i class="fa fa-link"></i> Boutique sur Dawanda',
            'required'  => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => "http://fr.dawanda.com/shop/HairFlowersAtelier"
            )
        ));
        $builder->add('littlemarket', "url", array(
            'label' => '<i class="fa fa-link"></i> Boutique sur ALittleMarket',
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => "http://www.alittlemarket.com/boutique/ecrindebijoux-1882123.html"
            )
        ));
        $builder->add('delai', "text", array(
            'required'  => true,
            'label' => "<i class='fa fa-clock-o'></i> Délai d'expédition",
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => "Délai d'expédition",
            )
        ));
        $builder->add('expedition', "textarea", array(
            'label' => '<i class="fa fa-truck"></i> Conditions d\'expédition de colis',
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => "Conditions d'expédition",
            )
        ));
        $builder->add('mention', "textarea", array(
            'required'  => true,
            'label' => '><i class="fa fa-legal"></i> Mentions Légales',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => "Mentions Légales",
            )
        ));
        $builder->add('optin', "checkbox", array(
            'required'  => true,
            'label' =>  "J'accèpte de recevoir la newsletter",
            'attr' => array(
            )
        ));

    }

    /**
     * Methode déprécié pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\JewelerMeta',
        ));
    }
    /**
     * Nom du formulaire
     * @return string|void
     */
    public function getName()
    {
        return "store_backend_jewelermeta";
    }

}


























