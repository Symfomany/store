<?php

namespace Store\BackendBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Store\BackendBundle\Util\Satanize;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class LocationValidator.
 */
class LocationValidator extends ConstraintValidator
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $value = Satanize::slugify($value);

        $coordonate = $this->em->getRepository('StoreBackendBundle:Villes')->getCordonneesByCity($value);

        if (!$coordonate) {
            $this->context->addViolation($constraint->message);
        }
    }
}
