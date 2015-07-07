<?php

// src/Acme/DemoBundle/Security/Authentication/Token/WsseUserToken.php
namespace Store\BackendBundle\Security\Authentification\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * Un token représente les données d'authentification de l'utilisateur présentes dans la requête
 * Une fois qu'une requête est authentifiée, le token conserve les données de l'utilisateur, et délivre ces données au travers du contexte de sécurité.
 *  Cela permettra de passer toutes les informations pertinentes à votre fournisseur d'authentification.
 * Class WsseUserToken.
 */
class WsseUserToken extends AbstractToken
{
    /**
     * @var created
     */
    public $created;

    /**
     * @var digest
     */
    public $digest;

    /**
     * @var
     */
    public $nonce;

    /**
     * Constructor.
     *
     * @param array $roles
     */
    public function __construct(array $roles = array())
    {
        parent::__construct($roles);

        // Si l'utilisateur a des rôles, on le considère comme authentifié
        $this->setAuthenticated(count($roles) > 0);
    }

    /**
     * get Credentials.
     *
     * @return string
     */
    public function getCredentials()
    {
        return '';
    }
}
