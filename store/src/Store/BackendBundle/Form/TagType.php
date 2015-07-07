<?php

namespace Store\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TagType
 * Formulaire de création de tag.
 */
class TagType extends AbstractType
{
    /**
     * Methode qui va consrtuire mon formulaire.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajoute un champs dans mon formulaire
        // Le nom de mes champs sont mes attributs de l'entité Product
        // le 2eme argument à ma fonction add() est le type de mon champs
        // le 3eme argument c'est ùmes options à mon chamos
        $builder->add('word', null, array(
            'label' => 'Mots-clef', //label de mon chmpa
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
                'pattern' => '[a-zA-Z0-9.- ]{3,}',
            ),
        ));

        $builder->add('envoyer', 'submit', array(
            'attr' => array(
                'class' => 'btn btn-primary btn-sm',
            ),
        ));
    }

    /**
     * Cette methode me permet de lié mon formulaire à moin entité Product
     * CAR mon formulaire enregistre un produit dans la table product.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // je lis le formulaire à l'entité Product
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\Tag',
        ));
    }

    /**
     * Methode déprécié pour lier un formulaire à une entité.
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\Tag',
        ));
    }

    /**
     * Nom du formulaire.
     *
     * @return string|void
     */
    public function getName()
    {
        return 'store_backend_tag';
    }
}
