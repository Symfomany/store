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
 * Class CmsType
 * Formulaire de création de produit
 * @package Store\BackendBundle\Form
 */
class CmsType extends AbstractType
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
            'label' => 'cms.form.title', //label de mon chmpa
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'cms.form.placeholder.title',
                'pattern' => '[a-zA-Z0-9- ]{5,}'
            )
        ));
        $builder->add('file', 'file', array(
            'label' => 'cms.form.image',
            'required'  => false,
            'attr' => array(
                'class' => 'form-control',
                'accept' => 'image/*',
                'capture' => 'capture'
            )
        ));
        $builder->add('video', 'text', array(
            'label' => 'cms.form.video',
            'required'  => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'cms.form.placeholder.video',
            )
        ));
        $builder->add('summary', null, array(
            'label' => 'cms.form.summary',
            'required'  => true,
            'attr' => array(
                    'class' => 'form-control',
                'placeholder' => 'cms.form.placeholder.summary',
             )
        ));
        $builder->add('description', null, array(
            'label' => 'cms.form.description',
            'required'  => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'cms.form.placeholder.description',
            )
        ));
        $builder->add('state', 'choice', array(
            'label' => 'cms.form.state',
            'choices'   => array(
                "1" => 'cms.form.statelabel.inactive',
                "2" => 'cms.form.statelabel.wait',
                "3" => 'cms.form.statelabel.active'),
            'required'  => true, // liste déroulante obligatoire
            'preferred_choices' => array("En cours de relecture"), // champs choisi par défault
            'attr' => array(
                'class' => 'form-control',
            )
        ));
        $builder->add('dateActive', 'datetime', array (
            'label' => 'cms.form.dateActive',
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'dd/mm/YYYY',
            ),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'pattern' => '{{ day }}/{{ month }}/{{ year }',
        ));

        $builder->add('product', 'entity',
            array (
                'label' => 'cms.form.product',
                'class' => 'StoreBackendBundle:Product',
                'multiple' => true, // choix multiple
                'by_reference' => false, // to handle setProduct() new method in entity
                'query_builder' => function(ProductRepository $er)
                {
                    return $er->getProductByUserBuilder($this->user);
                },
            ));


        $builder->add('envoyer', 'submit', array(
            'label' => "cms.form.send",
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
            'data_class' => 'Store\BackendBundle\Entity\Cms',
        ));
    }

    /**
     * Methode déprécié pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\Cms',
        ));
    }


    /**
     * Nom du formulaire
     * @return string|void
     */
    public function getName()
    {
        return "store_backend_cms";
    }

}


























