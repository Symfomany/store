<?php

namespace Store\BackendBundle\Form;


use Doctrine\ORM\EntityRepository;
use Store\BackendBundle\Entity\Product;
use Store\BackendBundle\Repository\CategoryRepository;
use Store\BackendBundle\Repository\ProductRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Le suffixe Type est Obligatoire pour mes classe Formulaires
 * Class ProductType
 * Formulaire de création de produit
 * @package Store\BackendBundle\Form
 */
class ProductType extends AbstractType
{

    /**
     * @var $user
     */
    protected $user;


    /**
     * User param
     * @param $user
     */
    public function __construct($user = null){
        $this->user = $user;
    }

    /**
     * Methode qui va consrtuire mon formulaire
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajoute un champs dans mon formulaire
        // Le nom de mes champs sont mes attributs de l'entité Product
        // le 2eme argument à ma fonction add() est le type de mon champs
        // le 3eme argument c'est ùmes options à mon chamos
        $builder->add('title', null, array(
            'label' => 'Titre de mon bijoux', //label de mon chmpa
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Mettre un titre soigné',
                'pattern' => '[a-zA-Z0-9- ]{5,}'
            )
        ));
        $builder->add('ref', null, array(
            'label' => 'Référence du produit',
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'AAAA-XX-B',
                'pattern' => '[A-Z]{4}-[0-9]{2}-[A-Z]{1}'
            )
        ));

        $builder->add('file', 'file', array(
            'label' => 'Image de présentation',
            'required'  => false,
            'attr' => array(
                'class' => 'form-control',
                'accept' => 'image/*',
                'capture' => 'capture'
            )
        ));

        //methode numéro 2
        $builder->add('category', 'entity',
        array (
            'label' => 'Catégorie',
            'attr' => array(
                'class' => 'form-control',
            ),
            'class' => 'StoreBackendBundle:Category',
            'property' => 'title',
            'multiple' => true, // choix multiple
            'expanded' => true, // checkbox plutot que liste déroulante
            'query_builder' => function(CategoryRepository $er)
            {
                return $er->getCategoryByUserBuilder($this->user);
            },
        ));

        $builder->add('summary', null, array(
            'label' => "Petit résumé",
            'required'  => true,
            'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Petit résumé du bijoux',
             )
        ));
        $builder->add('description', null, array(
            'label' => "Longue description",
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Description longue du bijoux',
            )
        ));
        $builder->add('composition', null, array(
            'label' => "Composition de votre bijoux",
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Composition du bijoux',
            )
        ));

        $builder->add('price', 'money', array(
            'label' => "Prix HT en €",
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Prix en €',
            )
        ));
        $builder->add('taxe', 'choice', array(
            'choices'   => array('5' => '5', '19.6' => '19.6', '20' => '20'),
            'required'  => true, // liste déroulante obligatoire
            'preferred_choices' => array('20'), // champs choisi par défault
            'label' => "Taxe appliquée",
            'attr' => array(
                'class' => 'form-control',
            )
        ));
        $builder->add('quantity', 'number', array(
            'required'  => true,
            'label' => "Quantité du produit",
            'attr' => array(
                'class' => 'form-control',
                'pattern' => '[0-9]{1,4}'
            )
        ));
        $builder->add('active', null, array(
            'label' => "Produit activé dans la boutique?"
        ));
        $builder->add('cover', null, array(
            'label' => "Produit mis en couverture dans la boutique?"
        ));
        $builder->add('cms', null, array(
            'label' => "Page(s) associée(s) au produit",
            'attr' => array(
                'class' => 'form-control',
            )
        ));
        $builder->add('supplier', null, array(
            'label' => "Fournisseur(s) associé(s) au produit",
            'attr' => array(
                'class' => 'form-control',
            )
        ));
        $builder->add('dateActive', 'date', array (
            'widget' => 'choice',
            'pattern' => '{{ day }}-{{ month }}-{{ year }',
        ));
        $builder->add('tag', null, array(
            'label' => "Tag(s) associé(s) au produit",
            'attr' => array(
                'class' => 'form-control',
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
            'data_class' => 'Store\BackendBundle\Entity\Product',
        ));
    }

    /**
     * Methode déprécié pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\Product',
        ));
    }


    /**
     * Nom du formulaire
     * @return string|void
     */
    public function getName()
    {
        return "store_backend_product";
    }

}


























