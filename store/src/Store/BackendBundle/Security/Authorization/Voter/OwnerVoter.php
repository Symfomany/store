<?php

namespace Store\BackendBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class OwnerVoter: qui va voter si l'utilisateur est permis de faire une action
 * @package Store\BackendBundle\Security\Authorization\Voter
 */
class OwnerVoter implements VoterInterface
{


    /**
     * Get Attribute of User
     * Les attributs accepté
     * @param string $attribute
     * @return bool
     */
    public function supportsAttribute($attribute)
    {
        return true;
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
                return VoterInterface::ACCESS_GRANTED; //ecces permis
            }
        }

        return VoterInterface::ACCESS_DENIED;


    }
}