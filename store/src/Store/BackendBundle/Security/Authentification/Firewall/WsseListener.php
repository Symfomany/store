<?php

// src/Acme/DemoBundle/Security/Firewall/WsseListener.php
namespace Store\BackendBundle\Security\Authentification\Firewall;

use Store\BackendBundle\Security\Authentification\Token\WsseUserToken;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;

/**
 * Le listener est chargé de transmettre les requêtes au pare-feu et d'appeler le fournisseur d'authentification
 * Ce listener vérifie l'en-tête X-WSSE attendu dans la réponse, fait correspondre la valeur retournée pour l'information WSSE attendue, crée un token utilisant cette information, et passe le token au gestionnaire d'authentification
 * Class WsseListener.
 */
class WsseListener implements ListenerInterface
{
    protected $securityContext;
    protected $authenticationManager;

    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager)
    {
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
    }

    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        /*
         * Prépare a requete a envoyé au Parefeu
         */
        $wsseRegex = '/UsernameToken Username="([^"]+)", PasswordDigest="([^"]+)", Nonce="([^"]+)", Created="([^"]+)"/';
        if (!$request->headers->has('x-wsse') || 1 !== preg_match($wsseRegex, $request->headers->get('x-wsse'), $matches)) {
            return;
        }

        /*
         * Création d'un Token pour l'utilisateur
         */
        $token = new WsseUserToken();
        $token->setUser($matches[1]);

        $token->digest = $matches[2];
        $token->nonce = $matches[3];
        $token->created = $matches[4];

        try {
            $authToken = $this->authenticationManager->authenticate($token);

            // association au contexte du token associé à l(utilostayr
            $this->securityContext->setToken($authToken);
        } catch (AuthenticationException $failed) {
            // ... you might log something here

            // To deny the authentication clear the token. This will redirect to the login page.
            // $this->securityContext->setToken(null);
            // return;

            // Deny authentication with a '403 Forbidden' HTTP response
            $response = new Response();
            $response->setStatusCode(403);
            $event->setResponse($response);
        }
    }
}
