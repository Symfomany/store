<?php

namespace Store\BackendBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Location extends Constraint
{
    // Message qui apparaoit dans ma contrainte de validation
    public $message = "Votre ville n'existe pas. Veuillez choisir une ville ";

    /**
     * Alias Service.
     *
     * @return string
     */
    public function validatedBy()
    {
        return 'validation_location';
    }
}
