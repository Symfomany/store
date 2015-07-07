<?php

namespace Store\BackendBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class StripTagLength extends Constraint
{
    // Message qui apparaoit dans ma contrainte de validation
    public $message = 'Le texte est trop long';
}
