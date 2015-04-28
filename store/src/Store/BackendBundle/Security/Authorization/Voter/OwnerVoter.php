<?php

namespace Store\BackendBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class OwnerVoter: qui va voter si l'utilisateur est permis de faire une action
 *
 * @package Store\BackendBundle\Security\Authorization\Voter
 */
class OwnerVoter implements VoterInterface
{

    /**
     * Get Attribute of User
     * Cette methode me permet de récuoérer le ou les attribut(s) envoyés depuis mon contronlleur
     * @param string $attribute
     * @return bool
     */
    public function supportsAttribute($attribute)
    {
        return true;
    }

    /**
     * Me permet de faire des restrictions sur l'utilisation de ce Voter
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return true;
    }

    /**
     * LE PLUS IMPORTANT
     * Mecanisme que l'on implémente pour voter les droits
     * et permissions de l'utilisateur
     *
     * @param TokenInterface $token
     * @param null|object $object
     * @param array $attributes
     * @return int
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
    /**
     * VoterInterface::ACCESS_DENIED: Acces non permis (403)
     * VoterInterface::ACCESS_GRANTED: Acces authorisée
     * VoterInterface::ACCESS_ABSTAIN: S'abstenir de voter sur le mecanisme
     * d'authorisation
     */
        // get current logged in user
        $user = $token->getUser();

        //si l'utilisateur n'est pas connecté
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

        //si le jeweler id est égale à l'id de l'utilisateur
        if(method_exists($object,'getJeweler')){
            if ($object->getJeweler()->getId() == $user->getId()) {
                return VoterInterface::ACCESS_GRANTED; //ecces permis
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }
}