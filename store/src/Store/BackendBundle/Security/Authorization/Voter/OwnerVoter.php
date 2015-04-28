<?php

namespace Store\BackendBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class OwnerVoter implements VoterInterface
{

    const VIEW = 'view';
    const EDIT = 'edit';
    const REMOVE = 'remove';

    /**
     * Get Attribute of User
     * Les attributs accepté
     * @param string $attribute
     * @return bool
     */
    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::VIEW,
            self::EDIT,
            self::REMOVE,
        ));
    }

    /**
     * Support All CLass
     * Restriction sur une classe ou plusieurs classe
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return true;
    }

    /**
     * Voter action
     * @param TokenInterface $token
     * @param null|object $object
     * @param array $attributes
     * @return int
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {

        if (count($attributes) == 0) {
            throw new \InvalidArgumentException(
                'Il y a aucun argument disponible'
            );
        }

        // set the attribute to check against
        $attribute = $attributes[0];

        // Le voter ne peut décider si il a main mise sur la restrition
        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // get current logged in user
        $user = $token->getUser();

        //si l'utilisateur n'est pas connecté
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

//        exit(var_dump($object->getJeweler()->getId() != $user->getId()));

        //si le jeweler id est égale à l'id de l'utilisateur
        if(method_exists($object,'getJeweler')){
            if ($object->getJeweler()->getId() == $user->getId()) {
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        return VoterInterface::ACCESS_DENIED;


    }
}