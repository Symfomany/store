<?php

namespace Store\BackendBundle\Form;


use Store\BackendBundle\Repository\ProductRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Le suffixe Type est Obligatoire pour mes classe Formulaires
 * Class SupplierType
 * Formulaire de création de produit
 * @package Store\BackendBundle\Form
 */
class SupplierType extends AbstractType
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
        $builder->add('name', null, array(
            'label' => 'Nom du fournisseur', //label de mon chmpa
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'pattern' => '[a-zA-Z0-9- ]{5,}'
            )
        ));

        $builder->add('file', 'file', array(
            'label' => 'Image de la catégorie',
            'required'  => false,
            'attr' => array(
                'class' => 'form-control',
                'accept' => 'image/*',
                'capture' => 'capture'
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

        $builder->add('product', 'entity',
            array (
                'label' => 'Produits associés',
                'class' => 'StoreBackendBundle:Product',
                'multiple' => true, // choix multiple
                'by_reference' => false, // to handle setProduct() new method in entity
                'query_builder' => function(ProductRepository $er)
                {
                    return $er->getProductByUserBuilder($this->user);
                },
            ));

        $builder->add('active', null, array(
            'label' => "Catégorie active ?",
            'required'  => false,
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
            'data_class' => 'Store\BackendBundle\Entity\Supplier',
        ));
    }

    /**
     * Methode déprécié pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\Supplier',
        ));
    }

    /**
     * Nom du formulaire
     * @return string|void
     */
    public function getName()
    {
        return "store_backend_supplier";
    }

}


























